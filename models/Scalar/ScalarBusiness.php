<?php

namespace app\models\scalar;

class ScalarBusiness
{
    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /**
     * ScalarBusiness constructor.
     *
     * @param array $data
     */
    public function __construct( array $data )
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }
}