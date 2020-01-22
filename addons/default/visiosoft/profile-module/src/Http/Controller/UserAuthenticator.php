<?php namespace Visiosoft\ProfileModule\Http\Controller;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\UsersModule\User\Authenticator\Contract\AuthenticatorExtensionInterface;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Anomaly\UsersModule\User\Event\UserWasLoggedIn;
use Anomaly\UsersModule\User\User;
use Anomaly\UsersModule\User\UserPassword;
use http\Env\Response;
use Visiosoft\AdvsModule\Adv\AdvModel;
use Visiosoft\AdvsModule\Http\Controller\AdvsController;
use Visiosoft\CartsModule\Saleitem\Command\ProcessSaleitem;
use Visiosoft\CartsModule\Saleitem\SaleitemModel;
use Visiosoft\CloudsiteModule\Site\Event\CreateSite;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Visiosoft\CloudsiteModule\Site\SiteModel;
use Visiosoft\ProfileModule\Profile\ProfileRepository;
use Visiosoft\SubscriptionsModule\User\UserModel;

/**
 * Class UserAuthenticator
 *
 * @link   http://visiosoft.com.tr/
 * @author Visiosoft, Inc. <support@visiosoft.com.tr>
 * @author Vedat Akdoğan <vedat@visiosoft.com.tr>
 */
class UserAuthenticator
{
    protected $guard;
    protected $events;
    protected $container;
    protected $extensions;
    protected $settings;
    protected $advModel;


    public function __construct(
        Guard $guard,
        Dispatcher $events,
        Container $container,
        ExtensionCollection $extensions,
        AdvModel $advModel,
        SettingRepositoryInterface $settings)
    {
        $this->guard = $guard;
        $this->events = $events;
        $this->container = $container;
        $this->extensions = $extensions;
        $this->advModel = $advModel;
        $this->settings = $settings;
    }

    /**
     * Attempt to login a user.
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool|UserInterface
     */

    function valid_email($email)
    {
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function attempt(Request $request, $remember = false, ProfileRepository $profileRepository)
    {
        $credentials = $request->toArray();
        if ($credentials) {
            unset($credentials['_token'], $credentials['remember_me']);
            if (!$this->valid_email($credentials['email'])) {
                $credentials['username'] = $credentials['email'];
                unset($credentials['email']);
                $validation = $profileRepository->validPasswordByUsername($credentials['username']);
            } else {
                $validation = $profileRepository->validPasswordByEmail($credentials['email']);
            }
            if ($validation == "noUser") {
                return Redirect::back()->with('error', [trans('visiosoft.module.profile::message.login_error')]);
            }
            if ($validation == "reset") {
                return Redirect::back()->with('info', [trans('visiosoft.module.profile::message.login_info_old_user')]);
            }
            if ($validation == "noMail") {
                return Redirect::back()->with('info', [trans('visiosoft.module.profile::message.login_noMail_old_user')
                    , trans('visiosoft.module.profile::message.login_noMail_old_user2'), trans('visiosoft.module.profile::message.login_noMail_old_user3')]);
            }
            if (isset($credentials['username'])) {
                $profile = $profileRepository->findProfileForLogin('gsm_phone', $credentials['username']);
                if ($profile != null) {
                    $find_user = $profileRepository->findUserForLogin('id', $profile->user_id);
                    $credentials['username'] = $find_user->username;
                }
            }
            if ($response = $this->authenticate($credentials)) {
                if ($response instanceof UserInterface) {
                    $this->login($response, $remember);
                    return Redirect::back();
                }
            }
        }
        return Redirect::back()->with('error', [trans('visiosoft.module.profile::message.login_error')]);
    }

    /**
     * Attempt to authenticate the credentials.
     *
     * @param array $credentials
     * @return bool|UserInterface
     */
    public function authenticate(array $credentials)
    {
        $authenticators = $this->extensions
            ->search('anomaly.module.users::authenticator.*')
            ->enabled();

        /* @var AuthenticatorExtensionInterface $authenticator */
        foreach ($authenticators as $authenticator) {

            $response = $authenticator->authenticate($credentials);

            if ($response instanceof UserInterface) {
                return $response;
            }

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        return false;
    }

    /**
     * Force login a user.
     *
     * @param UserInterface $user
     * @param bool $remember
     */
    public function login(UserInterface $user, $remember = false)
    {
        $this->guard->login($user, $remember);

        $this->events->dispatch(new UserWasLoggedIn($user));
    }

    public function registerAjax(UserRepositoryInterface $users, Request $request)
    {
        $required_field = ['first_name', 'last_name', 'email', 'subdomain'];

        foreach ($required_field as $field) {
            if (!isset($request->$field) or $request->$field == "") {
                return $this->responseJSON('error', $field . ' field is required!');
                die;
            }
        }

        $siteModel = new SiteModel();
        $userPlan = new UserModel();
        $all = $request->all();

        $email = explode('@', $all['email']);
        $all['display_name'] = $all['first_name'] . " " . $all['last_name'];
        $all['username'] = array_first($email);
        $all['username'] = preg_replace("/[^a-zA-Z0-9]/", "", $all['username']);
        $all['activated'] = 1;                                                      //Activated User
        $all['str_id'] = str_random(24);                                    //User random key
        $planParams['plan'] = 24;

        //find plan id for request
        if (isset($all['plan_id'])) {
            $planParams['plan'] = $all['plan_id'];
            unset($all['plan_id']);//Demo Plan id
        }

        //find subdomain in allready exit
        $isSubdomain = $siteModel->getSitesBySubdomain($all['subdomain']);
        if ($this->advModel->is_enabled('cloudsite') and !is_null($isSubdomain)) {
            return $this->responseJSON('error', 'This subdomain is already exists!');
        }


        if (User::withTrashed()->where('email', $all['email'])->first() or User::withTrashed()->where('username', $all['username'])->first()) {
            return $this->responseJSON('error', 'This Username or Email Registered!');

        }

        //create random password
        $opassword = str_random(8);

        $user_params = $all;
        unset($user_params['subdomain']);

        //create user
        $user = User::query()->create($user_params);
        $user->setAttribute('password', $opassword);
        $users->save($user);
        $all['password'] = $opassword;                                              //Register Password Original

        $all['user'] = $user;

        $planParams['user'] = $user->id;                                            //Register User id
        $planParams['name'] = $all['subdomain'];                                    //Subscription Saved Name

        if ($this->advModel->is_enabled('cloudsite')) {
            $plan = $userPlan->addPlanAjaxUser($planParams);
            $siteModel->createSite($all['subdomain'], $user->id, $opassword, $plan->id);       //Create Site
            //$this->events->dispatch(new CreateSite($all, $this->settings));
        }

        return $this->responseJSON('success', 'Thank you for Registering!');

    }

    public function responseJSON($type, $message)
    {
        return response()->json(['status' => $type, 'message' => $message]);
    }
}
