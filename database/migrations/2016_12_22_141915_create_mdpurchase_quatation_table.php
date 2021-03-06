<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdpurchaseQuatationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdpurchasequotation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mhpurchaquotationseno');
            $table->string('mdpurchasequotationsupplierid');
            $table->string('mdpurchasequotationsuppliername');
            $table->date('mdpurchasequotationdate');
            $table->string('mdpurchasequotationgoodsid');
            $table->string('mdpurchasequotationgoodsname');
            $table->integer('mdpurchasequotationgoodsunit3');
            $table->integer('mdpurchasequotationgoodsunit3conv');
            $table->string('mdpurchasequotationgoodsunit3label');
            $table->integer('mdpurchasequotationgoodsunit2');
            $table->integer('mdpurchasequotationgoodsunit2conv');
            $table->string('mdpurchasequotationgoodsunit2label');
            $table->integer('mdpurchasequotationgoodsunit1');
            $table->integer('mdpurchasequotationgoodsunit1conv');
            $table->string('mdpurchasequotationgoodsunit1label');

            $table->double('mdpurchasequotationbuyprice',16,2);
            
            $table->integer('mdpurchasequotationgoodsqty');
            $table->double('mdpurchasequotationgoodsprice',16,2);
            $table->double('mdpurchasequotationgoodsgrossamount',16,2);
            $table->double('mdpurchasequotationgoodsdiscount');
            $table->integer('mdpurchasequotationgoodsidwhouse');
            $table->text('mdpurchasequotationremarks');
            $table->double('mdpurchasetax');

            $table->integer('stock_ref');
            $table->integer('cogs_ref');
            $table->boolean('quotationed');
            
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
        Schema::drop('mdpurchasequotation');
    }
}
