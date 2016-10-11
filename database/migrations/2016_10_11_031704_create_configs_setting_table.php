<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mconfig',function(Blueprint $table){
          $table->increments('id');
          $table->string('msyscompname');
          $table->string('msyscompphone');
          $table->string('msyscompfax');
          $table->string('msyscompemail');
          $table->string('msyscompwebsite');
          $table->date('msyscompstartdate');
          $table->string('msyscompcurrency');
          $table->string('msyscompaddress');
          $table->string('msyscomplogo');

          $table->integer('msyscomptaxpayeridnumber');
          $table->string('msyscomptaxable');
          $table->date('msyscomptaxabledate');
          $table->integer('msyscomptaxablenumber');
          $table->string('msyscompklu');
          $table->string('msyscomptaxpayeridaddress');

          $table->boolean('msysgenmanufacturingacc');
          $table->boolean('msysgenmultibranch');
          $table->boolean('msysgenmulticurrency');
          $table->boolean('msysgendefaulttax');
          $table->boolean('msysgenapproval');
          $table->boolean('msysgenfixedasset');
          $table->integer('msysgenrounddec');

          $table->string('msysprefixgoods');
          $table->integer('msysprefixgoodscount');
          $table->string('msysprefixgoodslastcount');

          $table->string('msysprefixsupplier');
          $table->integer('msysprefixsuppliercount');
          $table->string('msysprefixsupplierlastcount');

          $table->string('msysprefixcustomer');
          $table->integer('msysprefixcustomercount');
          $table->string('msysprefixcustomerlastcount');

          $table->string('msysprefixemployee');
          $table->integer('msysprefixemployeecount');
          $table->string('msysprefixemployeelastcount');

          $table->string('msysprefixinvquotation');
          $table->integer('msysprefixinvquotationcount');
          $table->string('msysprefixinvquotationlastcount');

          $table->string('msysprefixinvorder');
          $table->integer('msysprefixinvordercount');
          $table->string('msysprefixinvorderlastcount');

          $table->string('msysprefixinvoice');
          $table->integer('msysprefixinvoicecount');
          $table->string('msysprefixinvoicelastcount');

          $table->string('msysprefixpurchrequest');
          $table->integer('msysprefixpurchrequestcount');
          $table->string('msysprefixpurchrequestlastcount');

          $table->string('msysprefixpurchorder');
          $table->integer('msysprefixpurchordercount');
          $table->string('msysprefixpurchorderlastcount');

          $table->string('msysprefixpurchinv');
          $table->integer('msysprefixpurchinvcount');
          $table->string('msysprefixpurchinvlastcount');

          $table->string('msysprefixedasset');
          $table->integer('msysprefixedassetcount');
          $table->string('msysprefixedassetlastcount');

          $table->string('msysprefixcashreceipt');
          $table->integer('msysprefixcashreceiptcount');
          $table->string('msysprefixcashreceiptlastcount');

          $table->string('msysprefixcashout');
          $table->integer('msysprefixcashoutcount');
          $table->string('msysprefixcashoutlastcount');

          $table->string('msysprefixbacnkrecon');
          $table->integer('msysprefixbacnkreconcount');
          $table->string('msysprefixbacnkreconlastcount');

          $table->boolean('msysinvquotation');
          $table->boolean('msysinvproformainvoice');
          $table->boolean('msysinvsellinginvoice');
          $table->boolean('msysinvlocksellingprice');
          $table->boolean('msysinvcreditlimit');
          $table->string('msysinvinvfootnote');
          $table->string('msysinvsellingfootnote');
          $table->boolean('msysinvspbelowcog');
          $table->boolean('msysinvprintinvmorethanonce');
          $table->boolean('msysinvprintdomorethanonce');
          $table->boolean('msysinvprintordmorethanonce');
          $table->integer('msysinvdefaultcreditlimit');
          $table->boolean('msysinvlptdirectprinting');

          $table->boolean('msyspurchrequest');
          $table->boolean('msyspurchorder');
          $table->boolean('msyspurchinvoice');
          $table->boolean('msyspurchcreditlimit');
          $table->string('msyspurchinvfootnote');
          $table->string('msyspurchorderfootnote');

          $table->string('msysacccogmethod');
          $table->string('msysaccstock');
          $table->string('msysaccinv');
          $table->string('msysaccreturninv');
          $table->string('msysaccinvdisc');
          $table->string('msysaccsentgoods');
          $table->string('msysaccsellingexpense');
          $table->string('msysaccreturnpurchase');
          $table->string('msysaccar');
          $table->string('msysacctrial');
          $table->string('msysaccpaidcapital');
          $table->string('msysaccretainedearning');
          $table->boolean('msysbankminus');

          $table->boolean('msysinventmultiwarehouse');
          $table->boolean('msysinventmultiuom');
          $table->boolean('msysinventuseserial');
          $table->boolean('msysinventallowminus');
          $table->boolean('msysinventslabprice');

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
        Schema::drop('mconfig');
    }
}
