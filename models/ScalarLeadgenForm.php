<?php

namespace app\models;

class ScalarLeadgenForm
{
    /** @var string */
    public $name;

    /** @var string */
    public $id;

    /** @var ScalarLeadgenFormField[] */
    public $fields = [];

    /**
     * ScalarLeadForm constructor.
     *
     * @param array $formData
     */
    public function __construct( array $formData )
    {
        $this->id = $formData['id'];
        $this->name = $formData['name'];

        foreach ( $formData['qualifiers'] as $fieldData )
        {
            $this->fields[] = new ScalarLeadgenFormField( $fieldData );
        }
    }
}