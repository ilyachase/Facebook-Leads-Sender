<?php

namespace app\models\Scalar;

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

    /** @var int */
    public $leadsCount = 0;

    /**
     * ScalarLeadForm constructor.
     *
     * @param array $leadFormData
     * @param int $leadsCount
     */
    public function __construct( array $leadFormData, $leadsCount )
    {
        if ( isset( $leadFormData['id'] ) )
            $this->id = $leadFormData['id'];

        if ( isset( $leadFormData['leadgen_export_csv_url'] ) )
            $this->exportUrl = $leadFormData['leadgen_export_csv_url'];

        if ( isset( $leadFormData['name'] ) )
            $this->name = $leadFormData['name'];

        if ( isset( $leadFormData['status'] ) )
            $this->status = $leadFormData['status'];

        $this->leadsCount = $leadsCount;
    }
}