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
            [['id', 'ruleset_id', 'client_id', 'check_interval', 'is_active', 'destination_id'], 'integer'],
            [['last_time_checked'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Connections::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ruleset_id' => $this->ruleset_id,
            'client_id' => $this->client_id,
            'check_interval' => $this->check_interval,
            'last_time_checked' => $this->last_time_checked,
            'destination_id' => $this->destination_id,
            'is_active' => $this->is_active,
        ]);

        return $dataProvider;
    }
}
