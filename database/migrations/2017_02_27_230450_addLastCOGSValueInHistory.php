<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastCOGSValueInHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hpphistory',function(Blueprint $table){
            $table->double('lastcogs')->after('hpphistorycogs');
            $table->double('lastqty')->after('lastcogs');
            $table->double('buyprice')->after('lastqty');
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
