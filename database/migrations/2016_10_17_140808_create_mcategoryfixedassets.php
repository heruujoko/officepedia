<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcategoryfixedassets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcategoryfixedassets', function (Blueprint $table) {
        $table->increments('id');
        $table->string('mcategoryfixedassetgroupcode');
        $table->string('mcategoryfixedassetgroupname');
        $table->string('mcategoryfixedassetage');
        $table->string('mcategoryfixedassetshrink');
        $table->string('mcategoryfixedassetdepreciaton');
        $table->string('mcategoryfixedassetcoaasset');
        $table->string('mcategoryfixedassetcoaaccudepr');
        $table->string('mcategoryfixedassetcoadeprexp');
        $table->string('mcategoryfixedassetremark');
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
        Schema::drop('mcategoryfixedassets');
    }
}
