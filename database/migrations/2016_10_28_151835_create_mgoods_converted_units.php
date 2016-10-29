<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoodsConvertedUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mgoods',function(Blueprint $table){
          $table->integer('mgoodsunit2conv')->after('mgoodsunit2');
          $table->integer('mgoodsunit3conv')->after('mgoodsunit3');
          $table->boolean('mgoodsmultiunit')->after('mgoodsremark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
