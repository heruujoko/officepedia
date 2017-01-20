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
          $table->double('mhinvoicesubtotal',16,2);
          $table->double('mhinvoicetaxtotal',16,2);
          $table->double('mhinvoicediscounttotal',16,2)->nullable();
          $table->double('mhinvoicegrandtotal',16,2);
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
