<?php

use yii\db\Migration;

class m170818_170448_connections_last_time_checked_key extends Migration
{
    public function safeUp()
    {
        $this->createIndex( 'last_time_checked', 'connections', 'last_time_checked' );
    }

    public function safeDown()
    {
        $this->dropIndex( 'last_time_checked', 'connections' );

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170818_170448_connections_last_time_checked_key cannot be reverted.\n";

        return false;
    }
    */
}
