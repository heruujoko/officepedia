<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMPrefixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mprefix', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mprefix')->unique();
            $table->string('mprefixtransaction');
            $table->string('mprefixremark')->nullable();
            $table->integer('last_count');
            $table->boolean('void');
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
        Schema::drop('mprefix');
    }
}
