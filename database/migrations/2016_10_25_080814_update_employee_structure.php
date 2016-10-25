<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memployee',function(Blueprint $table){
          $table->text('memployeeinfo');
          $table->dropColumn(['memployeecontactname', 'memployeecontactposition', 'memployeecontactemail','memployeecontactemailphone','memployeearlimit','memployeecoa','memployeetop','memployeearmax','memployeedefaultar']);
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
