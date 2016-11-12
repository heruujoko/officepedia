<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muser',function(Blueprint $table){
             $table->increments('id');
             $table->string('musername');
             $table->string('muserpass');
             $table->string('musercategory');
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
        Schema::table('muser', function (Blueprint $table) {
            Schema::drop('muser');
        });
    }
}
