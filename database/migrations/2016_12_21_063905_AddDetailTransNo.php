<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailTransNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdpayap',function(Blueprint $table){
            $table->string('mdpayaptransno')->after('mhpayapno');
            $table->integer('mdpayap_apref');
            $table->boolean('void')->default(0);
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
