<?php

use yii\db\Migration;

class m170723_182649_clients_table_creation extends Migration
{
    public function safeUp()
    {
        $this->createTable( 'clients', [
            'id'           => $this->bigPrimaryKey(),
            'name'         => $this->string( 255 ),
        ] );
    }

    public function safeDown()
    {
        $this->dropTable( 'clients' );
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170723_182649_clients_table_creation cannot be reverted.\n";

        return false;
    }
    */
}
