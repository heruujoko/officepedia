<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GoodsWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgoodswarehouse',function(Blueprint $table){
          $table->increments('id');
          $table->string('mgoodscode');
          $table->string('mwarehouseid');
          $table->string('mbranchid');
          $table->integer('stock');
          $table->timestamps();
        });
        Schema::drop('warehousegoodsstock');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mgoodswarehouse');
    }
}
