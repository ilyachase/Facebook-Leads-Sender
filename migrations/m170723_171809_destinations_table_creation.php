<?php

use yii\db\Migration;

class m170723_171809_destinations_table_creation extends Migration
{
    public function safeUp()
    {
        $this->createTable( 'destinations', [
            'id'           => $this->bigPrimaryKey(),
            'name'         => $this->string( 255 ),
            'client_id'    => $this->bigInteger(),
            'content_type' => $this->boolean(),
            'email_from'   => $this->string( 255 ),
            'email_to'     => $this->text(),
            'cc'           => $this->text(),
            'bcc'          => $this->text(),
            'subject'      => $this->text(),
        ] );
    }

    public function safeDown()
    {
        $this->dropTable( 'destinations' );
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170723_171809_destinations_table_creation cannot be reverted.\n";

        return false;
    }
    */
}
