<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMGoodstypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgoodstype', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mgoodstypename')->unique();
            $table->string('mgoodstyperemark');
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
        Schema::drop('mgoodstype');
    }
}
