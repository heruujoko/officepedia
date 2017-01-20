<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMPayAPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhpayap',function(Blueprint $table){
            $table->increments('id');
            $table->string('mhpayapno');
            $table->string('mhpayapsupplierno');
            $table->string('mhpayapsuppliername');
            $table->date('mhpayapdate');
            $table->string('mhpayapbank');
            $table->string('mhpayaprefno');
            $table->string('mhpayapcheckno');
            $table->double('mhpayappayamount');
            $table->double('mhpayapsubtotal',16,2);
            $table->double('mhpayapdiscounttotal',16,2);
            $table->double('mhpayapgrandtotal');
            $table->text('mhpayapremarks')->default('');
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
        Schema::drop('mhpayap');
    }
}
