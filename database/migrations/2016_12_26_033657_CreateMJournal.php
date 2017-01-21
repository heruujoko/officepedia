<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mjournal',function(Blueprint $table){
            $table->increments('id');
            $table->date('mjournaldate');
            $table->string('mjournaltransno');
            $table->string('mjournaltranstype');
            $table->string('mjournalcoa');
            $table->string('mjournalbranch');
            $table->double('mjournaldebit',16,2);
            $table->double('mjournalcredit',16,2);
            $table->text('mjournalremark');
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
        Schema::drop('mjournal');
    }
}
;
