<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMGoodssubtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgoodssubtype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mgoodssubtypename')->unique();
            $table->string('mgoodssubtypeparent')->unique();
            $table->string('mgoodssubtyperemark');
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
        Schema::drop('mgoodssubtype');
    }
}
