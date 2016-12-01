<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCOGS extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcogs',function(Blueprint $table){
            $table->increments('id');
            $table->string('mcogsgoodscode');
            $table->string('mcogsgoodsname');
            $table->integer('mcogsgoodstotalqty');
            $table->double('mcogslastcogs');
            $table->text('mcogsremarks');
            $table->boolean('void')->default(0);
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
        Schema::drop('mcogs');
    }
}
