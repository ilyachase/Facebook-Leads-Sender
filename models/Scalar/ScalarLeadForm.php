<?php

namespace app\models\scalar;

class ScalarLeadForm
{
    /** @var string */
    public $id;

    /** @var string */
    public $exportUrl;

    /** @var string */
    public $name;

    /** @var string */
    public $status;

    /**
     * ScalarLeadForm constructor.
     *
     * @param array $leadFormData
     */
    public function __construct( array $leadFormData )
    {
        if ( isset( $leadFormData['id'] ) )
            $this->id = $leadFormData['id'];

        if ( isset( $leadFormData['leadgen_export_csv_url'] ) )
            $this->exportUrl = $leadFormData['leadgen_export_csv_url'];

        if ( isset( $leadFormData['name'] ) )
            $this->name = $leadFormData['name'];

        if ( isset( $leadFormData['status'] ) )
            $this->status = $leadFormData['status'];
    }
}