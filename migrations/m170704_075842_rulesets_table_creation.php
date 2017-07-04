<?php

use yii\db\Migration;
use yii\db\Schema;

class m170704_075842_rulesets_table_creation extends Migration
{
    public function safeUp()
    {
        $this->createTable( 'rulesets', [
            'id'      => Schema::TYPE_BIGPK,
            'content' => Schema::TYPE_TEXT,
        ] );
    }

    public function safeDown()
    {
        return $this->dropTable( 'rulesets' );
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
