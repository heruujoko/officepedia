<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressDetailConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mconfig',function(Blueprint $table){
          $table->string('msysstreet');
          $table->string('msyscity');
          $table->string('msyszipcode');
          $table->string('msysprovince');
          $table->string('msyscountry');
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
