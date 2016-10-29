<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msupplier', function (Blueprint $table){
            $table->increments('id');
            $table->string('msupplierid');
            $table->string('msuppliername')->unique();
            $table->string('msupplieremail');
            $table->string('msupplierphone');
            $table->string('msupplierfax');
            $table->string('msupplierwebsite');
            $table->string('msupplieraddress');
            $table->string('msuppliercity');
            $table->string('msupplierzipcode');
            $table->string('msupplierprovince');
            $table->string('msuppliercountry');
            $table->string('msuppliercontactname')->nullable();
            $table->string('msuppliercontactposition')->nullable();
            $table->string('msuppliercontactemail')->nullable();
            $table->string('msuppliercontactemailphone')->nullable();
            $table->double('msupplierarlimit',10,2);
            $table->integer('msuppliercoa');
            $table->string('msuppliertop');
            $table->integer('msupplierarmax');
            $table->integer('msupplierdefaultar');
            $table->string('void');
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
        Schema::drop('msupplier');
    }
}
