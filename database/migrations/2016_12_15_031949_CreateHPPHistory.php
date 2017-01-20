<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHPPHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hpphistory',function(Blueprint $table){
            $table->increments('id');
            $table->string('hpphistorygoodsid');
            $table->double('hpphistorypurchase',16,2);
            $table->double('hpphistoryqty',16,2);
            $table->double('hpphistorycogs',16,2);
            $table->text('hpphistoryremarks')->nullable();
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
        Schema::drop('hpphistory');
    }
}
