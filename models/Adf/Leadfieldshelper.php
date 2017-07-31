<?php

namespace app\models\Adf;

use app\models\Scalar\ScalarFieldConnection;

class Leadfieldshelper
{
    /** @var array */
    private $_formFields = [];

    /** @var array */
    private $_fieldConnections = [];

    /**
     * Leadfieldshelper constructor.
     *
     * @param array $formFields
     * @param ScalarFieldConnection[] $fieldConnections
     */
    public function __construct( array $formFields, array $fieldConnections )
    {
        foreach ( $formFields as $formField )
        {
            $this->_formFields[$formField['field_key']] = $formField['id'];
        }

        foreach ( $fieldConnections as $connection )
        {
            $this->_fieldConnections[$connection->leadgenFieldId] = $connection->ADFfieldId;
        }
    }

    /**
     * @param array $leadFieldsData
     *
     * @return array
     */
    public function getAdfFieldsByLead( array $leadFieldsData )
    {
        $result = [];
        foreach ( $leadFieldsData as $field )
        {
            if ( empty( $field['values'] ) )
                continue;

            if ( isset( $this->_formFields[$field['name']] ) && isset( $this->_fieldConnections[$this->_formFields[$field['name']]] ) )
            {
                $result[$this->_fieldConnections[$this->_formFields[$field['name']]]] = current( $field['values'] );
            }
        }
        return $result;
    }
}