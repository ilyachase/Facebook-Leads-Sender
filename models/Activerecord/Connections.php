<?php

namespace app\models\activerecord;

/**
 * This is the model class for table "connections".
 *
 * @property integer $id
 * @property integer $ruleset_id
 * @property integer $client_id
 * @property integer $check_interval
 * @property string $last_time_checked
 * @property integer $destination_id
 * @property string $last_lead_time
 * @property integer $is_active
 */
class Connections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'connections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ruleset_id', 'client_id', 'check_interval', 'is_active', 'destination_id'], 'integer'],
            [['ruleset_id', 'check_interval', 'is_active'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ruleset_id' => 'Ruleset ID',
            'client_id' => 'Client ID',
            'check_interval' => 'Check Interval',
            'last_time_checked' => 'Last Time Checked',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @inheritdoc
     * @return ConnectionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConnectionsQuery(get_called_class());
    }
}
