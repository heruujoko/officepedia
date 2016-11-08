<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MstockcardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mstockcard',function(Blueprint $table){
          $table->increments('id');
          $table->string('mstockcardgoodsid');
          $table->string('mstockcardgoodsname');
          $table->date('mstockcarddate');
          $table->string('mstockcardtranstype');
          $table->string('mstockcardtransno');
          $table->text('mstockcardremark');
          $table->integer('mstockcardstockin');
          $table->integer('mstockcardstockout');
          $table->integer('mstockcardstocktotal');
          $table->integer('mstockcardwhouse');
          $table->integer('mstockcarduserid');
          $table->string('mstockcardusername');
          $table->date('mstockcardeventdate');
          $table->datetime('mstockcardeventtime');
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
        Schema::drop('mstockcard');
    }
}
