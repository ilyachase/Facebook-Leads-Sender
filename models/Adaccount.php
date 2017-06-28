<?php

namespace app\models;

class Adaccount
{
    public function __construct( \FacebookAds\Object\AdAccount $addaccount )
    {
        $this->id = $addaccount->getData()['id'];
    }

    /** @var string */
    public $id;
}