<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MDFixedAssetsPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mdpurchasefixedasset',function(Blueprint $table){
          $table->increments('id');
          $table->string('mdpurchasefixedassetjournalcode');
          $table->string('mdpurchasefixedassetdate');
          $table->string('mdpurchasefixedassetcoacode');
          $table->string('mdpurchasefixedassetcoaname');
          $table->string('mdpurchasefixedassetdebit');
          $table->string('mdpurchasefixedassetcredit');
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
        Schema::drop('mdpurchasefixedasset');
    }
}
