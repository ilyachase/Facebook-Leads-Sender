<?php

use yii\db\Migration;

class m170723_173146_connections_table_alter extends Migration
{
    public function safeUp()
    {
        $this->dropColumn( 'connections', 'email' );
        $this->addColumn( 'connections', 'destination_id', $this->bigInteger() );
    }

    public function safeDown()
    {
        $this->addColumn( 'connections', 'email', $this->string( 255 ) );
        $this->dropColumn( 'connections', 'destination_id' );
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170723_173146_connections_table_alter cannot be reverted.\n";

        return false;
    }
    */
}
