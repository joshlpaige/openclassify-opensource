<?php namespace Visiosoft\ProfileModule\Http\Controller;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\Streams\Platform\Model\Advs\AdvsAdvsEntryModel;
use Anomaly\Streams\Platform\Model\Options\OptionsAdvertisementEntryModel;
use Anomaly\Streams\Platform\Model\Profile\ProfileAdressEntryModel;
use Anomaly\Streams\Platform\Model\Users\UsersUsersEntryModel;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Anomaly\UsersModule\User\Password\Command\StartPasswordReset;
use Anomaly\UsersModule\User\UserPassword;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Rinvex\Subscriptions\Models\Plan;
use Rinvex\Subscriptions\Models\PlanSubscription;
use Visiosoft\AdvsModule\Adv\AdvModel;
use Visiosoft\AdvsModule\Adv\Contract\AdvRepositoryInterface;
use Visiosoft\AdvsModule\Adv\Event\ChangeStatusAd;
use Visiosoft\AdvsModule\AdvsModule;
use Visiosoft\LocationModule\Country\CountryModel;
use Visiosoft\AdvsModule\Http\Controller\AdvsController;
use Visiosoft\AlgoliaModule\Search\SearchModel;
use Visiosoft\CloudsiteModule\CloudsiteModule;
use Visiosoft\CloudsiteModule\Site\SiteModel;
use Visiosoft\OrdersModule\Order\OrderModel;
use Visiosoft\OrdersModule\Orderdetail\Event\AgainPuchaseOrder;
use Visiosoft\OrdersModule\Orderdetail\Event\AgainPurchaseOrder;
use Visiosoft\OrdersModule\Orderdetail\Event\AgainSaleOrder;
use Visiosoft\OrdersModule\Orderdetail\Event\ReportOrder;
use Visiosoft\OrdersModule\Orderdetail\OrderdetailModel;
use Visiosoft\OrdersModule\Orderdetail\OrderdetailRepository;
use Visiosoft\OrdersModule\Orderpayment\OrderpaymentModel;
use Visiosoft\PackagesModule\Http\Controller\PackageFEController;
use Visiosoft\MessagesModule\Message\MessageModel;
use Visiosoft\PackagesModule\Package\PackageModel;
use Visiosoft\PackagesModule\User\UserModel;
use Visiosoft\ProfileModule\Adress\AdressModel;
use Visiosoft\ProfileModule\Adress\Contract\AdressRepositoryInterface;
use Visiosoft\ProfileModule\Adress\Form\AdressFormBuilder;
use Visiosoft\ProfileModule\Profile\Contract\ProfileRepositoryInterface;
use Visiosoft\ProfileModule\Profile\Form\ProfileFormBuilder;
use Visiosoft\ProfileModule\Profile\ProfileModel;
use Illuminate\Contracts\Events\Dispatcher;


class MyProfileController extends PublicController
{
    private $adressRepository;
    private $userRepository;

    public function __construct(
        AdressRepositoryInterface $adressRepository,
        UserRepositoryInterface $userRepository
    )
    {
        parent::__construct();
        if (!Auth::user()) {
            redirect('/login?redirect=' . url()->current())->send();
        }

        $this->adressRepository = $adressRepository;
        $this->userRepository = $userRepository;
    }

    protected $user;

    public function home(ProfileFormBuilder $form, AdvRepositoryInterface $advRepository)
    {
        //clear empty ads
        $advRepository->delete_empty_advs();

        $advs_count = new AdvModel();
        $advs_count = count($advs_count->myAdvsByUser()->get());

        $user = $this->userRepository->find(Auth::id());

        $country = CountryModel::all();

        return $this->view->make('visiosoft.module.profile::profile.detail',
            compact('user','country', 'form', 'advs_count'));
    }


    public function extendAds($id, $type, SettingRepositoryInterface $settings)
    {
        $isActivePackages = new AdvModel();
        $isActivePackages = $isActivePackages->is_enabled('packages');

        if ($isActivePackages) {

            //Search Last Time Packages By User
            $TimePackages = new PackageFEController();
            $LastTimePackages = $TimePackages->getPackagesByUser('lasttime');

            //no packages by user
            if ($LastTimePackages == false) {
                return response()->json(['success' => false, 'msg' => trans('visiosoft.module.profile::message.no_extend_package')]);
            }

            //Search Time packages By id
            $TimePackages = $TimePackages->getTimePackages($LastTimePackages['package_id']);
            $adv = new AdvModel();
            $adv->finish_at_Ads($id, $TimePackages['time']);

            // auto approved find
            $auto_approved = $settings->value('visiosoft.module.advs::auto_approve');
            if ($auto_approved == true) {
                $type = "approved";
            }
            $adv->statusAds($id, $type);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'msg' => trans('visiosoft.module.profile::message.no_packages_module')]);
        }
    }

    public function statusAds($id, $type, SettingRepositoryInterface $settings, Dispatcher $events, AdvModel $advModel)
    {
        $ad = $advModel->getAdv($id);
        $auto_approved = $settings->value('visiosoft.module.advs::auto_approve');
        $default_published_time = $settings->value('visiosoft.module.advs::default_published_time');

        if ($auto_approved == true AND $type == 'pending_admin') {
            $type = "approved";
        }

        if ($type == "approved") {
            $advModel->publish_at_Ads($id);
            if ($ad->finish_at == NULL AND $type == "approved") {
                if ($advModel->is_enabled('packages')) {
                    $packageModel = new PackageModel();
                    $published_time = $packageModel->reduceTimeLimit($ad->cat1);
                    if ($published_time != null) {
                        $default_published_time = $published_time;
                    }
                }
                $advModel->finish_at_Ads($id, $default_published_time);
            }
        }
        $isActiveAlgolia = new AdvModel();
        $isActiveAlgolia = $isActiveAlgolia->is_enabled('algolia');
        if ($isActiveAlgolia) {
            $algolia = new SearchModel();
            $algolia->updateStatus($id, $type, $settings);
        }
        $status = $advModel->statusAds($id, $type);
        $events->dispatch(new ChangeStatusAd($id, $settings));//Create Notify

        return response()->json(['status' => $status]);

    }

    public function adressEdit($id)
    {
        $adressModel = new AdressModel();
        $adress = $adressModel->getAdressFirst($id);
        if ($adress->getAttribute('user_id') == Auth::id()) {
            $country = CountryModel::all();
            return $this->view->make('visiosoft.module.profile::address/edit', compact('adress', 'country'));
        }
    }

    public function adressSoftDelete($id)
    {
        $address = $this->adressRepository->find($id);
        if ($address->user_id == Auth::id()) {
            $address->update([
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
        }
        return $this->redirect->back();
    }

    public function adressUpdate(AdressFormBuilder $form, Request $request, $id)
    {
        $error = $form->build()->validate()->getFormErrors()->getMessages();
        if (!empty($error)) {
            return $this->redirect->back();
        }

        $adressModel = new AdressModel();
        $adress = $adressModel->getAdressFirst($id);

        if ($adress->getAttribute('user_id') == Auth::id()) {

            $New_value = $request->all();
            $New_value['country_id'] = $New_value['country'];
            unset($New_value['_token'], $New_value['action'], $New_value['country']);
            $adressModel->getAdress($id)->update($New_value);

            $message = [];
            $message[] = trans('visiosoft.module.profile::message.adress_success_update');
            return redirect(route('profile::address'))->with('success', $message);
        }
    }

    public function adressCreate(AdressFormBuilder $form, Request $request)
    {
        if (isset($request->request->all()['action']) == "save") {
            $error = $form->build()->validate()->getFormErrors()->getMessages();
            if (!empty($error)) {
                return $this->redirect->back();
            }
            $new_adress = $request->request->all();
            unset($new_adress['action'], $new_adress['_to*ken']);
            $new_adress['user_id'] = Auth::id();

            $adressModel = new AdressModel();
            $adressModel->getAdress()->create($new_adress);

            $message = [];
            $message[] = trans('visiosoft.module.profile::message.adress_success_create');
            return redirect(route('profile::address'))->with('success', $message);
        }
        $country = CountryModel::all();
        return $this->view->make('visiosoft.module.profile::address/create', compact('country'));
    }

    public function adressAjaxCreate(AdressFormBuilder $form, Request $request)
    {
        $message = [];

        $error = $form->build()->validate()->getFormErrors()->getMessages();
        if (!empty($error)) {
            $message['status'] = "error";
            $message['msg'] = trans('visiosoft.module.profile::message.required_all');
            return $message;
        }
        $new_adress = $request->request->all();
        unset($new_adress['_token']);
        $new_adress['user_id'] = Auth::id();

        $adressModel = new AdressModel();
        $address = $adressModel->getAdress()->create($new_adress);

        $message['status'] = "success";
        $message['data'] = $address;
        return $message;
    }

    public function adressAjaxUpdate(AdressFormBuilder $form, $id)
    {
        $address = $this->adressRepository->find($id);
        if (isset($id) and $address != null and $address->user_id == Auth::id()) {
            $message = [];
            $error = $form->build()->validate()->getFormErrors()->getMessages();
            if (!empty($error)) {
                $message['status'] = "error";
                $message['msg'] = trans('visiosoft.module.profile::message.required_all');
                return $message;
            }
            $new_adress = $this->request->all();
            unset($new_adress['_token']);

            $address->update($new_adress);

            $message['status'] = "updated";
            $message['data'] = $address;
            return $message;

        }
        $message['status'] = "error";
        $message['msg'] = trans('visiosoft.module.profile::message.ajax_address_error');
        return $message;
    }

    public function adressAjaxDetail()
    {
        $address = $this->adressRepository->find($this->request->id);
        if (isset($this->request->id) and $address != null and $address->user_id == Auth::id()) {
            $message['status'] = "success";
            $message['data'] = $address;
            return $message;
        }
        $message['status'] = "error";
        $message['msg'] = trans('visiosoft.module.profile::message.ajax_address_error');
        return $message;
    }


    public function showMessage($id)
    {
        $message = new MessageModel();
        $message = $message->showMessage($id);
        $messageInfo = $message[0];
        $messageDetail = $message[1];

        if ($message[0]->adv_user_id == auth()->id()) {
            return $this->view->make('visiosoft.module.profile::profile.message-detail', compact('messageInfo', 'messageDetail'));
        } else {
            abort(403);
        }
    }

    public function Address()
    {
        $address = new AdressModel();
        $address = $address->getUserAdress();
        return $this->view->make('visiosoft.module.profile::address/list', compact('address'));
    }

    public function disableAccount()
    {

        UsersUsersEntryModel::query()->find(Auth::id())->update(['enabled' => 0]);
        return redirect('/');
    }

    public function notification(Request $request)
    {
        $all = $request->all();
        unset($all['_']);
        $profileModel = new ProfileModel();
        $status = $profileModel->getProfile(Auth::id())->update($all);
        return response()->json($status);

    }

    public function myAds()
    {
        return $this->view->make('visiosoft.module.profile::profile/ads');
    }

}
