<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMhsalesquotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhsalesquotation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mhsalesquotationno');
            $table->string('mhsalesquotationdeliveryno')->nullable(true);
            $table->string('mhsalesquotationorderyno')->nullable(true);
            $table->string('mhsalesquotationsupplierid');
            $table->string('mhsalesquotationsuppliername');
            $table->date('mhsalesquotationdate');
            $table->date('mhsalesquotationduedate');
            $table->double('mhsalesquotationsubtotal');
            $table->double('mhsalesquotationtaxtotal');
            $table->double('mhsalesquotationdiscounttotal');
            $table->double('mhsalesquotationgrandtotal');
            $table->double('mhsalesquotationothertotal');
            $table->boolean('mhsalesquotationwithppn')->default(0);
            $table->text('mhsalesquotationremark');
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
        Schema::drop('mhsalesquotation');
    }
}
