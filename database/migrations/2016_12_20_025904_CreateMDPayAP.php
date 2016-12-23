<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMDPayAP extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdpayap',function(Blueprint $table){
            $table->increments('id');
            $table->string('mhpayapno');
            $table->date('mdpayapinvoicedate');
            $table->double('mdpayapinvoicetotal');
            $table->double('mdpayapinvoiceoutstanding');
            $table->double('mdpayapinvoicepayamount');
            $table->double('mdpayapinvoicediscount');
            $table->string('mdpayapuserid');
            $table->string('mdpayapusername');
            $table->datetime('mdpayapeventdate');
            $table->datetime('mdpayapeventtime');
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
        Schema::drop('mdpayap');
    }
}
