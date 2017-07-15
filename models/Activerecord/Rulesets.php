<?php

namespace app\models\activerecord;
use app\models\scalar\ScalarFieldConnection;

/**
 * This is the model class for table "rulesets".
 *
 * @property integer $id
 * @property integer $leadform_id
 */
class Rulesets extends \yii\db\ActiveRecord
{
    /** @var ScalarFieldConnection[] */
    public $fieldConnections = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rulesets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'content' ], 'string' ],
        ];
    }

    public static function findOne( $condition )
    {
        /** @var Rulesets $ruleset */
        $ruleset = parent::findOne( $condition );
        if ( $ruleset )
        {
            $ruleset->fieldConnections = unserialize( $ruleset->content );
        }

        return $ruleset;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'leadform_id' => 'Lead Form ID',
            'content'     => 'Content',
        ];
    }

    /**
     * @param int $formId
     * @param array $post
     *
     * @return $this
     */
    public function fillFromPost( $formId, array $post )
    {
        // TODO: update by id AND leadgen_id
        if ( $old = self::findOne( [ 'leadform_id' => $formId ] ) )
        {
            $this->setIsNewRecord( false );
            $this->setOldAttributes( $old->getAttributes() );
        }

        foreach ( $post['fieldConnections'] as $leadFormFileId => $data )
        {
            $this->fieldConnections[] = new ScalarFieldConnection( $leadFormFileId, $data );
        }

        $this->leadform_id = $formId;
        $this->content = serialize( $this->fieldConnections );

        return $this;
    }
}
