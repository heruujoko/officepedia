<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMgoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mgoods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mgoodscode')->unique();
            $table->string('mgoodsbarcode')->unique();
            $table->string('mgoodsname')->unique();
            $table->string('mgoodsalias');
            $table->string('mgoodstype');
            $table->string('mgoodsbrand');
            $table->string('mgoodsgroup1');
            $table->string('mgoodsgroup2');
            $table->string('mgoodsgroup3');
            $table->string('mgoodsremark');
            $table->string('mgoodsunit');
            $table->string('mgoodsunit2');
            $table->string('mgoodsunit3');
            $table->string('mgoodssuppliercode');
            $table->string('mgoodssuppliername');
            $table->float('mgoodspricein');
            $table->float('mgoodspriceout')->unique();
            $table->string('mgoodcoapurchasing')->unique();
            $table->string('mgoodscoapurchasingname')->unique();
            $table->string('mgoodscoacogs')->unique();
            $table->string('mgoodscoacogsname')->unique();
            $table->string('mgoodscoaselling')->unique();
            $table->string('mgoodscoasellingname')->unique();
            $table->string('mgoodscoareturnofselling')->unique();
            $table->string('mgoodscoareturnofsellingname')->unique();
            $table->float('mgoodscogs');
            $table->boolean('mgoodsactive');
            $table->boolean('mgoodsuniquetransaction');
            $table->boolean('mgoodsbranches');
            $table->string('mgoodspicture');
            $table->string('mgoodsunit2convert');
            $table->string('mgoodsunit3convert');
            $table->string('void');
            $table->timestamps();
        });

         Schema::create('mbranch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mbranchcode')->unique();
            $table->string('mbranchname');
            $table->string('address');
            $table->string('phone');
            $table->string('city');
            $table->string('person_in_charge');
            $table->string('information');
            $table->string('void');
            $table->timestamps();
        });
           Schema::create('triggermbranch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('date');
            $table->string('user');
        });


         Schema::create('mcoa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mcoacode')->unique();
            $table->string('mcoaname');
            $table->string('mcoatype');

            // relation cannot be unique. they only unique on their own tables.
            $table->string('mcoaparentcode');
            $table->string('mcoaparentname');
            $table->string('mcoagrandparentcode');
            $table->string('mcoagrandparentname');
            $table->string('void');
            $table->timestamps();
        });
          Schema::create('mcoaparent', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mcoaparentcode')->unique();
            $table->string('mcoaparentname')->unique();
            $table->string('mcoaparenttype');
            $table->string('mcoagrandparentcode');
            $table->string('mcoagrandparentname');
            $table->string('void');
            $table->timestamps();
        });
            Schema::create('mcoagrandparent', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mcoagrandparentcode')->unique();
            $table->string('mcoagrandparentname')->unique();
            $table->string('mcoagrandparenttype');
            $table->string('void');
            $table->timestamps();
        });
        Schema::create('mcustomer', function (Blueprint $table){
            $table->increment('id');
            $table->string('mcustomerid');
            $table->string('mcustomername');
            $table->string('mcustomeremail');
            $table->string('mcustomerphone');
            $table->string('mcustomerfax');
            $table->string('mcustomerwebsite');
            $table->string('mcustomeraddress');
            $table->string('mcustomercity');
            $table->string('mcustomerzipcode');
            $table->string('mcustomerprovince');
            $table->string('mcustomer');

        })

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mcoagrandparent');
        Schema::drop('mcoaparent');
        Schema::drop('mcoa');
        Schema::drop('mgoods');
        Schema::drop('mbranch');
        Schema::drop('triggermbranch');
    }
}
