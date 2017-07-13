<?php

use yii\db\Migration;
use yii\db\Schema;

class m170704_075842_rulesets_table_creation extends Migration
{
    public function safeUp()
    {
        $this->createTable( 'rulesets', [
            'id'          => Schema::TYPE_BIGPK,
            'leadform_id' => Schema::TYPE_BIGINT,
            'content'     => Schema::TYPE_TEXT,
            'KEY `leadform_id` (leadform_id)'
        ] );
    }

    public function safeDown()
    {
        $this->dropTable( 'rulesets' );
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170704_075842_rulesets_table_creation cannot be reverted.\n";

        return false;
    }
    */
}
