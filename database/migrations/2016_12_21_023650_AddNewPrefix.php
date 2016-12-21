<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPrefix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mconfig',function(Blueprint $table){
           $table->string('msysprefixpayap');
           $table->integer('msysprefixpayapcount');
           $table->string('msysprefixpayaplastcount');

           $table->string('msysprefixpayar');
           $table->integer('msysprefixpayarcount');
           $table->string('msysprefixpayarlastcount');

           $table->string('msysprefixpurchasequotation');
           $table->integer('msysprefixpurchasequotationcount');
           $table->string('msysprefixpurchasequotationlastcount');

           $table->string('msysprefixinvoicequotation');
           $table->integer('msysprefixinvoicequotationcount');
           $table->string('msysprefixinvoicequotationlastcount');
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
