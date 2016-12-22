<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MDPayARTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdpayar',function(Blueprint $table){
            $table->increments('id');
            $table->string('mhpayarno');
            $table->string('mdpayartransno');
            $table->date('mdpayarinvoicedate');
            $table->double('mdpayarinvoicetotal');
            $table->double('mdpayarinvoiceoutstanding');
            $table->double('mdpayarinvoicepayamount');
            $table->double('mdpayarinvoicediscount');
            $table->string('mdpayaruserid');
            $table->string('mdpayarusername');
            $table->datetime('mdpayareventdate');
            $table->datetime('mdpayareventtime');
            $table->integer('mdpayar_arref');
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
        Schema::drop('mdpayar');
    }
}
