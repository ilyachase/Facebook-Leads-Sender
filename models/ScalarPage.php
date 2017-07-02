<?php

namespace app\models;

class ScalarPage
{
    /** @var string */
    public $name;

    /** @var string */
    public $category;

    /** @var string */
    public $id;

    /** @var bool */
    public $haveForms = false;

    /**
     * ScalarLeadForm constructor.
     *
     * @param array $pageData
     * @param bool $haveForms
     */
    public function __construct( array $pageData, $haveForms = false )
    {
        $this->id = $pageData['id'];
        $this->name = $pageData['name'];
        $this->category = $pageData['category'];
        $this->haveForms = $haveForms;
    }
}