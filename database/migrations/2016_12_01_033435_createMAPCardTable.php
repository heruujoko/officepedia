<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMAPCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapcard',function(Blueprint $table){
            $table->increments('id');
            $table->string('mapcardsupplierid');
            $table->string('mapcardsuppliername');
            $table->date('mapcardtdate');
            $table->string('mapcardtranstype');
            $table->string('mapcardtransno');
            $table->text('mapcardremark');
            $table->date('mapcardduedate');
            $table->double('mapcardtotalinv');
            $table->double('mapcardpayamount',16,2);
            $table->double('mapcardoutstanding',16,2);
            $table->integer('mapcarduserid');
            $table->string('mapcardusername');
            $table->timestamp('mapcardeventdate');
            $table->timestamp('mapcardeventtime');
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
        Schema::drop('mapcard');
    }
}
