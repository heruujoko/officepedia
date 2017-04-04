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
          $table->string('mhpurchasefixedassetno');
          $table->string('mdpurchasefixedassetjournalcode');
          $table->string('mdpurchasefixedassetdate');
          $table->string('mdpurchasefixedassetcoacode');
          $table->string('mdpurchasefixedassetcoaname');
          $table->double('mdpurchasefixedassetdebit');
          $table->double('mdpurchasefixedassetcredit');
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
        Schema::drop('mdpurchasefixedasset');
    }
}
