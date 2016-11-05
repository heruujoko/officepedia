<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mtax',function(Blueprint $table){
            $table->increments('id');
            $table->string('mtaxtype');
            $table->string('mtaxtdesc');
            $table->integer('mtaxtpercentage');
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
        Schema::drop('mtax');
    }
}
