<?php

namespace app\models\scalar;

class ScalarLeadgenFormField
{
    /** @var string */
    public $question;

    /** @var string */
    public $id;

    /**
     * ScalarLeadgenFormField constructor.
     *
     * @param array $fieldData
     */
    public function __construct( array $fieldData )
    {
        $this->id = $fieldData['id'];
        $this->question = $fieldData['question'];
    }
}