<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultiUnitsToGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mgoods',function(Blueprint $table){
            $table->integer('mgoodscurrentunit3');
            $table->integer('mgoodscurrentunit3conv')->after('mgoodscurrentunit3');
            $table->string('mgoodscurrentunit3label')->after('mgoodscurrentunit3conv');
            $table->integer('mgoodscurrentunit2')->after('mgoodscurrentunit3label');
            $table->integer('mgoodscurrentunit2conv')->after('mgoodscurrentunit2');
            $table->string('mgoodscurrentunit2label')->after('mgoodscurrentunit2conv');
            $table->integer('mgoodscurrentunit1')->after('mgoodscurrentunit2label');
            $table->integer('mgoodscurrentunit1conv')->after('mgoodscurrentunit1');
            $table->string('mgoodscurrentunit1label')->after('mgoodscurrentunit1conv');
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
