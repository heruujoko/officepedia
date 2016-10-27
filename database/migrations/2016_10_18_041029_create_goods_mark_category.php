<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsMarkCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcategorygoodsmark',function(Blueprint $table){
          $table->increments('id');
          $table->string('category_name')->nullable(false);;
          $table->string('information');
          $table->string('void');
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
        Schema::drop('mcategorygoodsmark');
    }
}
