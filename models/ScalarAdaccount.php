<?php

namespace app\models;

class ScalarAdaccount
{
    /** @var string */
    public $id;

    /** @var bool */
    public $haveForms = false;

    /**
     * ScalarAdaccount constructor.
     *
     * @param \FacebookAds\Object\AdAccount $addaccount
     * @param array $formsData
     */
    public function __construct( \FacebookAds\Object\AdAccount $addaccount, array $formsData )
    {
        $this->id = $addaccount->getData()['id'];

        if ( !empty( $formsData ) )
        {
            $this->haveForms = true;
        }
    }
}