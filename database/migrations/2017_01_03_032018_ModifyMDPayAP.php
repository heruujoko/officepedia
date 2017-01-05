<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMDPayAP extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdpayap',function(Blueprint $table){
            $table->string('mdpayapcashcoa');
            $table->double('mdpayapcashamount');
            $table->string('mdpayapbankcoa');
            $table->string('mdpayapbankbankname');
            $table->double('mdpayapbankamount');
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
