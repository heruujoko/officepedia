<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMGoodsbrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgoodsbrand', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mgoodsbrandname')->unique();
            $table->string('mgoodsbrandremark');
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
        Schema::drop('mgoodsbrand');
    }
}
