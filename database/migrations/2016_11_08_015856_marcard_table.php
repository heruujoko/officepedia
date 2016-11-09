<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MarcardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcard',function(Blueprint $table){
          $table->increments('id');
          $table->string('marcardcustomerid');
          $table->string('marcardcustomername');
          $table->date('marcarddate');
          $table->string('marcardtrastype');
          $table->string('marcardtrasno');
          $table->text('marcardremark');
          $table->date('marcardduedate');
          $table->double('marcardtotalinv');
          $table->boolean('marcardpayamount');
          $table->boolean('marcardoutstanding');
          $table->integer('marcarduserid');
          $table->string('marcardusername');
          $table->date('marcardusereventdate');
          $table->datetime('marcardusereventtime');
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
      Schema::drop('marcard');
    }
}
