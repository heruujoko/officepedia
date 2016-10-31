<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('munits',function(Blueprint $table){
          $table->increments('id');
          $table->string('mgoodsunitname');
          $table->string('mgoodsunitremark');
          $table->boolean('void');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('munits');
    }
}
