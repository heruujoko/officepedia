<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MHPayARTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhpayar',function(Blueprint $table){
            $table->increments('id');
            $table->string('mhpayarno');
            $table->string('mhpayarcustomerno');
            $table->string('mhpayarcustomername');
            $table->date('mhpayardate');
            $table->string('mhpayarbank');
            $table->string('mhpayarrefno');
            $table->string('mhpayarcheckno');
            $table->double('mhpayarpayamount');
            $table->double('mhpayarsubtotal');
            $table->double('mhpayardiscounttotal');
            $table->double('mhpayargrandtotal');
            $table->text('mhpayarremarks')->default('');
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
        Schema::drop('mhpayar');
    }
}
