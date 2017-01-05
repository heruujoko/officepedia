<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMdsalesquotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdsalesquotation', function (Blueprint $table) {
           $table->increments('id');
            $table->string('mhsalesotationseno');
            $table->string('mdsalesquotationsupplierid');
            $table->string('mdsalesquotationsuppliername');
            $table->date('mdsalesquotationdate');
            $table->string('mdsalesquotationgoodsid');
            $table->string('mdsalesquotationgoodsname');
            $table->integer('mdsalesquotationgoodsunit3');
            $table->integer('mdsalesquotationgoodsunit3conv');
            $table->string('mdsalesquotationgoodsunit3label');
            $table->integer('mdsalesquotationgoodsunit2');
            $table->integer('mdsalesquotationgoodsunit2conv');
            $table->string('mdsalesquotationgoodsunit2label');
            $table->integer('mdsalesquotationgoodsunit1');
            $table->integer('mdsalesquotationgoodsunit1conv');
            $table->string('mdsalesquotationgoodsunit1label');

            $table->double('mdsalesquotationbuyprice');
            
            $table->integer('mdsalesquotationgoodsqty');
            $table->double('mdsalesquotationgoodsprice');
            $table->double('mdsalesquotationgoodsgrossamount');
            $table->double('mdsalesquotationgoodsdiscount');
            $table->integer('mdsalesquotationgoodsidwhouse');
            $table->text('mdsalesquotationremarks');
            $table->double('mdsalestax');

            $table->integer('stock_ref');
            $table->integer('cogs_ref');
            
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
        Schema::drop('mdsalesquotation');
    }
}
