<?php

namespace app\models\activerecord;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property string $name
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'name' ], 'string', 'max' => 255 ],
            [ [ 'name' ], 'required' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'name' => 'Name',
        ];
    }
}
