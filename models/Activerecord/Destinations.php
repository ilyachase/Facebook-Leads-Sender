<?php

namespace app\models\Activerecord;

/**
 * This is the model class for table "destinations".
 *
 * @property integer $id
 * @property string $name
 * @property integer $client_id
 * @property integer $content_type
 * @property string $email_from
 * @property string $email_to
 * @property string $cc
 * @property string $bcc
 * @property string $subject
 */
class Destinations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'destinations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'client_id', 'content_type' ], 'integer' ],
            [ [ 'name', 'email_to', 'subject' ], 'required' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'name'         => 'Name',
            'client_id'    => 'Client ID',
            'content_type' => 'Content Type',
            'email_to'     => 'Email To',
            'cc'           => 'Cc',
            'bcc'          => 'Bcc',
            'subject'      => 'Subject',
        ];
    }
}
