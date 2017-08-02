<?php

namespace app\models\Activerecord;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RulesetsSearch represents the model behind the search form about `app\models\Activerecord\Rulesets`.
 */
class RulesetsSearch extends Rulesets
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'id', 'leadform_id' ], 'integer' ],
            [ [ 'name' ], 'string' ],
            [ [ 'content' ], 'safe' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search( $params )
    {
        $query = Rulesets::find();

        $dataProvider = new ActiveDataProvider( [
            'query' => $query,
        ] );

        $this->load( $params );

        if ( !$this->validate() )
        {
            return $dataProvider;
        }

        $query->andFilterWhere( [
            'leadform_id' => $this->leadform_id,
        ] );

        $query->andFilterWhere( [ 'like', 'name', $this->name ] );

        return $dataProvider;
    }
}
