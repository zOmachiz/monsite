<?php namespace Charles\Marketing\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCharlesMarketingClients extends Migration
{
    public function up()
    {
        Schema::table('charles_marketing_clients', function($table)
        {
            $table->string('logo')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('charles_marketing_clients', function($table)
        {
            $table->dropColumn('logo');
        });
    }
}
