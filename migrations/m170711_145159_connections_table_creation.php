<?php

use yii\db\Migration;

class m170711_145159_connections_table_creation extends Migration
{
    public function safeUp()
    {
        $this->createTable( 'connections', [
            'id'                => $this->bigPrimaryKey(),
            'ruleset_id'        => $this->bigInteger(),
            'client_id'         => $this->bigInteger(),
            'check_interval'    => $this->integer(),
            'last_time_checked' => $this->timestamp(),
            'is_active'         => $this->boolean(),
            'KEY `check_interval_is_active` (check_interval, is_active)',
            'KEY `client_id` (client_id)',
        ] );
    }

    public function safeDown()
    {
        $this->dropTable( 'connections' );
        return;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170711_145159_connections_table_creation cannot be reverted.\n";

        return false;
    }
    */
}
