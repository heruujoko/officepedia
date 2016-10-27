<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreditLimitToCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mcustomer',function(Blueprint $table){
          $table->double('mcustomerarlimit',10,2);
          $table->integer('mcustomercoa');
          $table->string('mcustomertop');
          $table->integer('mcustomerarmax');
          $table->integer('mcustomerdefaultar');
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
