<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMwarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mwarehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mwarehousename');
            $table->string('mwarehouseremark');
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
        
             Schema::drop('mwarehouse');
        
    }
}
