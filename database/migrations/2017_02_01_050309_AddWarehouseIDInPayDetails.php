<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWarehouseIDInPayDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdpayap',function(Blueprint $table){
            $table->integer('mdpayapwarehouseid');
        });
        Schema::table('mdpayar',function(Blueprint $table){
            $table->integer('mdpayarwarehouseid');
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
