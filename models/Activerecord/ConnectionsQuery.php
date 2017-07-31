<?php

namespace app\models\Activerecord;

/**
 * This is the ActiveQuery class for [[Connections]].
 *
 * @see Connections
 */
class ConnectionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Connections[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Connections|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
