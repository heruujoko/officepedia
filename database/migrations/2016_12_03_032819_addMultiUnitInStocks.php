<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultiUnitInStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mstockcard',function(Blueprint $table){
            // $table->integer('mstockcardunit3')->after('mstockcardstocktotal');
            // $table->integer('mstockcardunit3conv')->after('mstockcardunit3');
            // $table->string('mstockcardunit3label')->after('mstockcardunit3conv');
            // $table->integer('mstockcardunit2')->after('mstockcardunit3label');
            // $table->integer('mstockcardunit2conv')->after('mstockcardunit2');
            // $table->string('mstockcardunit2label')->after('mstockcardunit2conv');
            // $table->integer('mstockcardunit1')->after('mstockcardunit2label');
            // $table->integer('mstockcardunit1conv')->after('mstockcardunit1');
            // $table->string('mstockcardunit1label')->after('mstockcardunit1conv');
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
