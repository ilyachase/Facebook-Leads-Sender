<?php

namespace app\models\Activerecord;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ConnectionsSearch represents the model behind the search form about `app\models\Connections`.
 */
class ConnectionsSearch extends Connections
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'id', 'ruleset_id', 'client_id', 'check_interval', 'is_active', 'destination_id' ], 'integer' ],
            [ [ 'name' ], 'string' ],
            [ [ 'last_time_checked' ], 'safe' ],
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
        $query = Connections::find();

        $dataProvider = new ActiveDataProvider( [
            'query' => $query,
        ] );

        $this->load( $params );

        if ( !$this->validate() )
        {
            return $dataProvider;
        }

        $query->andFilterWhere( [
            'client_id'      => $this->client_id,
            'check_interval' => $this->check_interval,
            'destination_id' => $this->destination_id,
        ] );

        $query->andFilterWhere( [ 'like', 'name', $this->name ] );

        return $dataProvider;
    }
}
