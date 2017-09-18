<?php

use yii\db\Migration;

class m170918_161037_alter_destinations_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn( 'destinations', 'vendor_id', $this->string() );
        $this->addColumn( 'destinations', 'vendor_id_source', $this->string() );
        $this->addColumn( 'destinations', 'vendor_name', $this->string() );
        $this->addColumn( 'destinations', 'vendor_contact_name', $this->string() );
        $this->addColumn( 'destinations', 'provider_id', $this->string() );
        $this->addColumn( 'destinations', 'provider_id_source', $this->string() );
        $this->addColumn( 'destinations', 'provider_name', $this->string() );
    }

    public function safeDown()
    {
        $this->dropColumn( 'destinations', 'vendor_id' );
        $this->dropColumn( 'destinations', 'vendor_id_source' );
        $this->dropColumn( 'destinations', 'vendor_name' );
        $this->dropColumn( 'destinations', 'vendor_contact_name' );
        $this->dropColumn( 'destinations', 'provider_id' );
        $this->dropColumn( 'destinations', 'provider_id_source' );
        $this->dropColumn( 'destinations', 'provider_name' );
    }
}
