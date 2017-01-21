<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMDPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdpurchase',function(Blueprint $table){
            $table->increments('id');
            $table->string('mhpurchaseno');
            $table->string('mdpurchasesupplierid');
            $table->string('mdpurchasesuppliername');
            $table->date('mdpurchasedate');
            $table->string('mdpurchasegoodsid');
            $table->string('mdpurchasegoodsname');
            $table->integer('mdpurchasegoodsunit3');
            $table->integer('mdpurchasegoodsunit3conv');
            $table->string('mdpurchasegoodsunit3label');
            $table->integer('mdpurchasegoodsunit2');
            $table->integer('mdpurchasegoodsunit2conv');
            $table->string('mdpurchasegoodsunit2label');
            $table->integer('mdpurchasegoodsunit1');
            $table->integer('mdpurchasegoodsunit1conv');
            $table->string('mdpurchasegoodsunit1label');
            $table->integer('mdpurchasegoodsqty');
            $table->double('mdpurchasegoodsprice',16,2);
            $table->double('mdpurchasegoodsgrossamount',16,2);
            $table->double('mdpurchasegoodsdiscount');
            $table->integer('mdpurchasegoodsidwhouse');
            $table->text('mdpurchaseremarks');
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
        Schema::drop('mdpurchase');
    }
}
