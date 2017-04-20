<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsedFieldToMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mgoods',function(Blueprint $table){
          $table->boolean('used')->default(0);
        });
        Schema::table('mcoa',function(Blueprint $table){
          $table->boolean('used')->default(0);
        });
        Schema::table('mcustomer',function(Blueprint $table){
          $table->boolean('used')->default(0);
        });
        Schema::table('msupplier',function(Blueprint $table){
          $table->boolean('used')->default(0);
        });
        Schema::table('munits',function(Blueprint $table){
          $table->boolean('used')->default(0);
        });
        Schema::table('mwarehouse',function(Blueprint $table){
          $table->boolean('used')->default(1);
        });
        Schema::table('mbranch',function(Blueprint $table){
          $table->boolean('used')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
