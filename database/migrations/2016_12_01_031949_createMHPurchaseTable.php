<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMHPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhpurchase',function(Blueprint $table){
            $table->increments('id');
            $table->string('mhpurchaseno');
            $table->string('mhpurchasedeliveryno')->nullable(true);
            $table->string('mhpurchaseorderyno')->nullable(true);
            $table->string('mhpurchasesupplierid');
            $table->string('mhpurchasesuppliername');
            $table->date('mhpurchasedate');
            $table->date('mhpurchaseduedate');
            $table->double('mhpurchasesubtotal');
            $table->double('mhpurchasetaxtotal');
            $table->double('mhpurchasediscounttotal');
            $table->double('mhpurchasegrandtotal');
            $table->double('mhpurchaseothertotal');
            $table->boolean('mhpurchasewithppn')->default(0);
            $table->text('mhpurchaseremark');
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
        Schema::drop('mhpurchase');
    }
}
