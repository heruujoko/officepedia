<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memployee',function(Blueprint $table){
          $table->increments('id');
          $table->string('memployeeid');
          $table->string('memployeetitle');
          $table->string('memployeename');
          $table->string('memployeeposition');
          $table->integer('memployeelevel');
          $table->string('memployeephone');
          $table->string('memployeehomephone');
          $table->string('memployeebbmpin');
          $table->string('memployeeidcard');
          $table->string('memployeecity');
          $table->string('memployeezipcode');
          $table->string('memployeeprovince');
          $table->string('memployeecountry');
          $table->string('memployeecontactname');
          $table->string('memployeecontactposition');
          $table->string('memployeecontactemail');
          $table->string('memployeecontactemailphone');
          $table->float('memployeearlimit');
          $table->string('memployeecoa');
          $table->string('memployeetop');
          $table->integer('memployeearmax');
          $table->integer('memployeedefaultar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('memployee');
    }
}
