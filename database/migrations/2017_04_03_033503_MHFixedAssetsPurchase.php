<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MHFixedAssetsPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhpurchasefixedasset',function(Blueprint $table){
          $table->increments('id');
          $table->string('mhpurchasefixedassetcode');
          $table->string('mhpurchasefixedassetname');
          $table->date('mhpurchasefixedassetdate');
          $table->boolean('mhpurchasefixedassetreal');
          $table->integer('mhpurchasefixedassetcategory');
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
        Schema::drop('mhpurchasefixedasset');
    }
}
