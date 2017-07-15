<?php

use yii\db\Migration;

class m170715_172713_connections_alter extends Migration
{
    public function safeUp()
    {
        $this->addColumn( 'connections', 'last_lead_time', $this->timestamp() );
        $this->addColumn( 'connections', 'email', $this->string( 255 ) );
    }

    public function safeDown()
    {
        $this->dropColumn( 'connections', 'last_lead_time' );
        $this->dropColumn( 'connections', 'email' );

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170715_172713_connections_alter cannot be reverted.\n";

        return false;
    }
    */
}
