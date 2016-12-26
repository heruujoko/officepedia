<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewCOAConfigForJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mconfig',function(Blueprint $table){
            $table->string('msyspayapaccount')->after('msysaccretainedearning');
            $table->string('msyspayaraccount')->after('msyspayapaccount');
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
