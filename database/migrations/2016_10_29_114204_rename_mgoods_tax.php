<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameMgoodsTax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mgoods',function(Blueprint $table){
          $table->renameColumn('mgoodtaxppn', 'mgoodstaxppn');
          $table->renameColumn('mgoodtaxppnbm', 'mgoodstaxppnbm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
