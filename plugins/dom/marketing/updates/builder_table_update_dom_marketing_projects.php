<?php namespace Dom\Marketing\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateDomMarketingProjects extends Migration
{
    public function up()
    {
        Schema::table('dom_marketing_projects', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('dom_marketing_projects', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
