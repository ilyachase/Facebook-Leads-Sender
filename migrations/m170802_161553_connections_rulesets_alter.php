<?php

use yii\db\Migration;

class m170802_161553_connections_rulesets_alter extends Migration
{
    public function safeUp()
    {
        $this->addColumn( 'connections', 'name', $this->string( 255 ) );
        $this->addColumn( 'rulesets', 'name', $this->string( 255 ) );
    }

    public function safeDown()
    {
        $this->dropColumn( 'connections', 'name' );
        $this->dropColumn( 'rulesets', 'name' );

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170802_161553_connections_rulesets_alter cannot be reverted.\n";

        return false;
    }
    */
}
