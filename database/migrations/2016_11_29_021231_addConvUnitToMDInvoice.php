<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConvUnitToMDInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mdinvoice',function($table){
            $table->integer('mdinvoiceunit3')->after('mdinvoicegoodsname')->nullable(true);
            $table->integer('mdinvoiceunit3conv')->after('mdinvoiceunit3')->nullable(true);
            $table->string('mdinvoiceunit3label')->after('mdinvoiceunit3conv')->nullable(true);
            $table->integer('mdinvoiceunit2')->after('mdinvoiceunit3label')->nullable(true);
            $table->integer('mdinvoiceunit2conv')->after('mdinvoiceunit2')->nullable(true);
            $table->string('mdinvoiceunit2label')->after('mdinvoiceunit2conv')->nullable(true);
            $table->integer('mdinvoiceunit1')->after('mdinvoiceunit2label')->nullable(true);
            $table->integer('mdinvoiceunit1conv')->after('mdinvoiceunit1')->nullable(true);
            $table->string('mdinvoiceunit1label')->after('mdinvoiceunit1conv')->nullable(true);
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
