<?php

namespace app\models\scalar;

class ScalarFieldConnection
{
    const KEY_QUESTION = 'question';
    const KEY_ADF_FIELD_ID = 'ADFFieldId';

    /** @var string */
    public $leadgenFieldId;

    /** @var string */
    public $leadgenFieldQuestion;

    /** @var int */
    public $ADFfieldId;

    /**
     * ScalarFieldConnection constructor.
     *
     * @param int $leadFormFileId
     * @param array $data
     */
    public function __construct( $leadFormFileId, array $data )
    {
        $this->leadgenFieldId = (string) $leadFormFileId;
        $this->ADFfieldId = $data[self::KEY_ADF_FIELD_ID];
        $this->leadgenFieldQuestion = $data[self::KEY_QUESTION];
    }
}