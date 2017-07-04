<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rulesets".
 *
 * @property integer $id
 * @property string $content
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'content' => 'Content',
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
        if ( $old = self::findOne( $formId ) )
        {
            $this->setIsNewRecord( false );
            $this->setOldAttributes( $old->getAttributes() );
        }

        foreach ( $post['fieldConnections'] as $leadFormFileId => $data )
        {
            $this->fieldConnections[] = new ScalarFieldConnection( $leadFormFileId, $data );
        }

        $this->id = $formId;
        $this->content = serialize( $this->fieldConnections );

        return $this;
    }
}
