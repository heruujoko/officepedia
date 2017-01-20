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
            $table->double('mhpurchasesubtotal',16,2);
            $table->double('mhpurchasetaxtotal',16,2);
            $table->double('mhpurchasediscounttotal',16,2);
            $table->double('mhpurchasegrandtotal',16,2);
            $table->double('mhpurchaseothertotal',16,2);
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
