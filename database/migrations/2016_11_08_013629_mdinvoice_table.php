<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MdinvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdinvoice',function(Blueprint $table){
          $table->increments('id');
          $table->string('mhinvoiceno');
          $table->string('mdcustomerid');
          $table->string('mdcustomername')->nullable();
          $table->date('mdinvoicedate');
          $table->string('mdinvoicegoodsid')->nullable();
          $table->string('mdinvoicegoodsname')->nullable();
          $table->integer('mdinvoicegoodsqty');
          $table->double('mdinvoicegoodsprice');
          $table->double('mdinvoicegoodsgrossamount');
          $table->double('mdinvoicegoodsdiscount');
          $table->boolean('mdinvoicegoodstax');
          $table->integer('mdinvoicegoodsidwhouse');
          $table->text('mdinvoiceremarks')->nullable();
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
        Schema::drop('mdinvoice');
    }
}
