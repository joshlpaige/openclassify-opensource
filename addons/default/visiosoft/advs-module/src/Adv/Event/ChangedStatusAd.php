<?php namespace Visiosoft\AdvsModule\Adv\Event;

use Visiosoft\AdvsModule\Adv\AdvModel;

class ChangedStatusAd
{
    private $ad;

    public function __construct(AdvModel $ad)
    {
        $this->ad = $ad;
    }

    public function getAdDetail()
    {
        return $this->ad;
    }
}

