<?php

namespace app\models\Activerecord;

use app\models\Scalar\ScalarFieldConnection;
use FacebookAds\Object\LeadgenForm;
use FacebookAds\Object\Page;
use yii\helpers\Html;

/**
 * This is the model class for table "rulesets".
 *
 * @property integer $id
 * @property integer $leadform_id
 * @property string $name
 * @property-read string $facebookPageLink
 */
class Rulesets extends \yii\db\ActiveRecord
{
    /** @var ScalarFieldConnection[] */
    public $fieldConnections = [];

    /** @var string */
    private $_facebookPageLink;

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
            [ [ 'name' ], 'required' ],
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
        foreach ( $post['fieldConnections'] as $leadFormFileId => $data )
        {
            $this->fieldConnections[$leadFormFileId] = new ScalarFieldConnection( $leadFormFileId, $data );
        }

        $this->leadform_id = $formId;
        $this->name = $post['Rulesets']['name'];
        $this->content = serialize( $this->fieldConnections );

        return $this;
    }

    /**
     * @return string empty if entitny can be deleted
     */
    public function getDeletionErrorMessage()
    {
        $connections = Connections::find()->where( [ 'ruleset_id' => $this->id ] )->all();
        if ( count( $connections ) )
        {
            $message = "In order to delete this Destination you have to first delete or edit following connections:";

            $elements = [];
            foreach ( $connections as $connection )
            {
                $elements[] = Html::a( $connection->name, [ 'connections/view', 'id' => $connection->id ] );
            }
            $message .= Html::ul( $elements, [ 'encode' => false ] );

            return $message;
        }

        return '';
    }

    /**
     * @param string $adfFieldId
     *
     * @return ScalarFieldConnection|null
     */
    public function getConnectionByAdfFieldId( $adfFieldId )
    {
        foreach ( $this->fieldConnections as $connection )
        {
            if ( $connection->ADFfieldId == $adfFieldId )
                return $connection;
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'facebookPageLink':
                if ( null === $this->_facebookPageLink )
                {
                    $formData = ( new LeadgenForm( $this->leadform_id ) )->read( [ 'page_id' ] )->getData();
                    $page = ( new Page( $formData['page_id'] ) )->read( [ 'name' ] )->getData();
                    if ( $formData['page_id'] )
                    {
                        $this->_facebookPageLink = Html::a( $page['name'], "https://www.facebook.com/{$formData['page_id']}", [ 'target' => '_blank' ] );
                    }
                }
                return $this->_facebookPageLink;
                break;
        }

        return parent::__get( $name );
    }
}
