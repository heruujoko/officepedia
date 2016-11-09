<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MhinvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhinvoice',function(Blueprint $table){
          $table->increments('id');
          $table->string('mhinvoiceno')->unique();
          $table->string('mhinvoicecustomerid');
          $table->string('mhinvoicecustomername');
          $table->date('mhinvoicedate');
          $table->date('mhinvoiceduedate');
          $table->double('mhinvoicesubtotal');
          $table->double('mhinvoicetaxtotal');
          $table->double('mhinvoicediscounttotal')->nullable();
          $table->double('mhinvoicegrandtotal');
          $table->boolean('mhinvoicewithppn');
          $table->text('mhinvoiceremark')->nullable();
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
        Schema::drop('mhinvoice');
    }
}
