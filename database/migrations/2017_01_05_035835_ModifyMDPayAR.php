<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMDPayAR extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdpayar',function(Blueprint $table){
            $table->string('mdpayarcashcoa');
            $table->double('mdpayarcashamount',16,2);
            $table->string('mdpayarbankcoa');
            $table->string('mdpayarbankbankname');
            $table->double('mdpayarbankamount',16,2);
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
