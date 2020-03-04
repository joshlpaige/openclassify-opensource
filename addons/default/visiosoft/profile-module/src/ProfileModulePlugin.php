<?php namespace Visiosoft\ProfileModule;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Visiosoft\ProfileModule\Adress\Command\GetAddress;

class ProfileModulePlugin extends Plugin
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'getAddress',
                function ($id) {

                    if (!$ad = $this->dispatch(new GetAddress($id))) {
                        return null;
                    }

                    return $ad;
                }
            )
        ];
    }
}
