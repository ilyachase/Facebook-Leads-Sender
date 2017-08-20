<?php

namespace app\models\Activerecord;

use yii\helpers\Html;

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

    /**
     * @return string empty if entitny can be deleted
     */
    public function getDeletionErrorMessage()
    {
        $connections = Connections::find()->where( [ 'client_id' => $this->id ] )->all();
        $destinations = Destinations::find()->where( [ 'client_id' => $this->id ] )->all();
        if ( count( $connections ) || count( $destinations ) )
        {
            $message = "In order to delete this Client you have to first delete or edit following entities:";

            $elements = [];
            foreach ( $connections as $connection )
            {
                $elements[] = Html::a( $connection->name, [ 'connections/view', 'id' => $connection->id ] );
            }

            foreach ( $destinations as $destination )
            {
                $elements[] = Html::a( $destination->name, [ 'destinations/view', 'id' => $destination->id ] );
            }
            $message .= Html::ul( $elements, [ 'encode' => false ] );

            return $message;
        }

        return '';
    }
}
