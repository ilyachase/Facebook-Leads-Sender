<?php

namespace app\models\Scalar;

class ScalarFieldConnection
{
    const KEY_QUESTION = 'question';
    const KEY_ADF_FIELD_ID = 'ADFFieldId';
    const KEY_INCLUDE_QUESTION = 'includeQuestion';

    /** @var string */
    public $leadgenFieldId;

    /** @var string */
    public $leadgenFieldQuestion;

    /** @var string */
    public $ADFfieldId;

    /** @var bool */
    public $includeQuestion = false;

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
        if ( isset( $data[self::KEY_INCLUDE_QUESTION] ) && $data[self::KEY_INCLUDE_QUESTION] == true )
        {
            $this->includeQuestion = true;
        }
    }
}