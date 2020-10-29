<?php namespace Visiosoft\AdvsModule;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Twig_Environment;
use Visiosoft\AdvsModule\Adv\AdvModel;
use Visiosoft\AdvsModule\Adv\Command\appendRequestURL;
use Visiosoft\AdvsModule\Adv\Command\GetAd;
use Visiosoft\AdvsModule\Adv\Command\getPopular;
use Visiosoft\AdvsModule\Adv\Command\GetUserAds;
use Visiosoft\AdvsModule\Adv\Command\isActive;
use Visiosoft\AdvsModule\Adv\Command\LatestAds;
use Visiosoft\AdvsModule\Currency\Currency;
use Visiosoft\AdvsModule\Currency\CurrencyFormat;

class AdvsModulePlugin extends Plugin
{

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'adDetail',
                function ($id) {

                    if (!$ad = $this->dispatch(new GetAd($id))) {
                        return null;
                    }

                    return $ad;
                }
            ), new \Twig_SimpleFunction(
                'currencyFormat',
                function ($number, $currency = null, array $options = []) {
                    return app(CurrencyFormat::class)->format($number, $currency, $options);
                }
            ), new \Twig_SimpleFunction(
                'isActive',
                function ($name, $type = 'module', $project = 'visiosoft') {

                    if (!$isActive = $this->dispatch(new isActive($name, $type, $project))) {
                        return 0;
                    }

                    return $isActive;
                }
            ), new \Twig_SimpleFunction(
                'latestAds',
                function () {

                    if (!$latestAds = $this->dispatch(new LatestAds())) {
                        return 0;
                    }

                    return $latestAds;
                }
            ),
            new \Twig_SimpleFunction(
                'appendRequestURL',
                function ($request, $url, $new_parameters, $removeParams = []) {

                    return $this->dispatch(new appendRequestURL($request, $url, $new_parameters, $removeParams));
                }
            ),
            new \Twig_SimpleFunction(
                'getUserAllAdvs',
                function ($user = null) {
                    if (!$user) {
                        $user = auth()->user();
                    }

                    $advModel = new AdvModel();
                    return $advModel->newQuery()
                        ->where('advs_advs.created_by_id', $user->id)
                        ->get();
                }
            ),
            new \Twig_SimpleFunction(
                'getUserAds',
                function ($userID = null) {
                    return $this->dispatch(new GetUserAds($userID));
                }
            ),
            new \Twig_SimpleFunction(
                'getUserPassiveAdvs',
                function ($user = null) {
                    if (!$user) {
                        $user = auth()->user();
                    }

                    $advModel = new AdvModel();

                    return $advModel->pendingAdvsByUser()->get();
                }
            ),
            new \Twig_SimpleFunction(
                'fn',
                function (Twig_Environment $twig, $name, ...$args) {
                    $fn = $twig->getFunction($name);

                    if ($fn === false) {
                        return null;
                    }

                    return $fn->getCallable()(...$args);
                }, ['needs_environment' => true]
            ), new \Twig_SimpleFunction(
                'getPopular',
                function () {
                    if (!$popular = $this->dispatch(new getPopular())) {
                        return null;
                    }
                    return $popular;
                }
            ),
        ];
    }
}
