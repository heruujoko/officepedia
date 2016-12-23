<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMhpurchaseQuatationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhpurchasequotation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mhpurchasequotationno');
            $table->string('mhpurchasequotationdeliveryno')->nullable(true);
            $table->string('mhpurchasequotationorderyno')->nullable(true);
            $table->string('mhpurchasequotationsupplierid');
            $table->string('mhpurchasequotationsuppliername');
            $table->date('mhpurchasequotationdate');
            $table->date('mhpurchasequotationduedate');
            $table->double('mhpurchasequotationsubtotal');
            $table->double('mhpurchasequotationtaxtotal');
            $table->double('mhpurchasequotationdiscounttotal');
            $table->double('mhpurchasequotationgrandtotal');
            $table->double('mhpurchasequotationothertotal');
            $table->boolean('mhpurchasequotationwithppn')->default(0);
            $table->text('mhpurchasequotationremark');
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
        Schema::drop('mhpurchasequotation');
    }
}
