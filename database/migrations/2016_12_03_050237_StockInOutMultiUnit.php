<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StockInOutMultiUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mstockcard',function(Blueprint $table){
            $table->integer('mstockcardinunit3');
            $table->integer('mstockcardinunit3conv');
            $table->string('mstockcardinunit3label');
            $table->integer('mstockcardinunit2');
            $table->integer('mstockcardinunit2conv');
            $table->string('mstockcardinunit2label');
            $table->integer('mstockcardinunit1');
            $table->integer('mstockcardinunit1conv');
            $table->string('mstockcardinunit1label');

            $table->integer('mstockcardoutunit3');
            $table->integer('mstockcardoutunit3conv');
            $table->string('mstockcardoutunit3label');
            $table->integer('mstockcardoutunit2');
            $table->integer('mstockcardoutunit2conv');
            $table->string('mstockcardoutunit2label');
            $table->integer('mstockcardoutunit1');
            $table->integer('mstockcardoutunit1conv');
            $table->string('mstockcardoutunit1label');
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
