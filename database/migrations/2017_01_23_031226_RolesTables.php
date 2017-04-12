<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles',function(Blueprint $table){
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('C_config')->default(0);
            $table->boolean('R_config')->default(0);
            $table->boolean('U_config')->default(0);
            $table->boolean('D_config')->default(0);

            $table->boolean('C_mcoa')->default(0);
            $table->boolean('R_mcoa')->default(0);
            $table->boolean('U_mcoa')->default(0);
            $table->boolean('D_mcoa')->default(0);

            $table->boolean('C_generaljournal')->default(0);
            $table->boolean('R_generaljournal')->default(0);
            $table->boolean('U_generaljournal')->default(0);
            $table->boolean('D_generaljournal')->default(0);

            $table->boolean('C_fixedasset')->default(0);
            $table->boolean('R_fixedasset')->default(0);
            $table->boolean('U_fixedasset')->default(0);
            $table->boolean('D_fixedasset')->default(0);

            $table->boolean('C_cashbank')->default(0);
            $table->boolean('R_cashbank')->default(0);
            $table->boolean('U_cashbank')->default(0);
            $table->boolean('D_cashbank')->default(0);

            $table->boolean('C_cashbankincome')->default(0);
            $table->boolean('R_cashbankincome')->default(0);
            $table->boolean('U_cashbankincome')->default(0);
            $table->boolean('D_cashbankincome')->default(0);

            $table->boolean('C_cashbankoutcome')->default(0);
            $table->boolean('R_cashbankoutcome')->default(0);
            $table->boolean('U_cashbankoutcome')->default(0);
            $table->boolean('D_cashbankoutcome')->default(0);

            $table->boolean('C_cashbanktransfer')->default(0);
            $table->boolean('R_cashbanktransfer')->default(0);
            $table->boolean('U_cashbanktransfer')->default(0);
            $table->boolean('D_cashbanktransfer')->default(0);

            $table->boolean('C_purchase')->default(0);
            $table->boolean('R_purchase')->default(0);
            $table->boolean('U_purchase')->default(0);
            $table->boolean('D_purchase')->default(0);

            $table->boolean('C_payap')->default(0);
            $table->boolean('R_payap')->default(0);
            $table->boolean('U_payap')->default(0);
            $table->boolean('D_payap')->default(0);

            $table->boolean('C_purchaseorder')->default(0);
            $table->boolean('R_purchaseorder')->default(0);
            $table->boolean('U_purchaseorder')->default(0);
            $table->boolean('D_purchaseorder')->default(0);

            $table->boolean('C_supplier')->default(0);
            $table->boolean('R_supplier')->default(0);
            $table->boolean('U_supplier')->default(0);
            $table->boolean('D_supplier')->default(0);

            $table->boolean('C_categorysupplier')->default(0);
            $table->boolean('R_categorysupplier')->default(0);
            $table->boolean('U_categorysupplier')->default(0);
            $table->boolean('D_categorysupplier')->default(0);

            $table->boolean('C_sales')->default(0);
            $table->boolean('R_sales')->default(0);
            $table->boolean('U_sales')->default(0);
            $table->boolean('D_sales')->default(0);

            $table->boolean('C_salesquotation')->default(0);
            $table->boolean('R_salesquotation')->default(0);
            $table->boolean('U_salesquotation')->default(0);
            $table->boolean('D_salesquotation')->default(0);

            $table->boolean('C_payar')->default(0);
            $table->boolean('R_payar')->default(0);
            $table->boolean('U_payar')->default(0);
            $table->boolean('D_payar')->default(0);

            $table->boolean('C_customer')->default(0);
            $table->boolean('R_customer')->default(0);
            $table->boolean('U_customer')->default(0);
            $table->boolean('D_customer')->default(0);

            $table->boolean('C_categorycustomer')->default(0);
            $table->boolean('R_categorycustomer')->default(0);
            $table->boolean('U_categorycustomer')->default(0);
            $table->boolean('D_categorycustomer')->default(0);

            $table->boolean('C_categoryprice')->default(0);
            $table->boolean('R_categoryprice')->default(0);
            $table->boolean('U_categoryprice')->default(0);
            $table->boolean('D_categoryprice')->default(0);

            $table->boolean('C_goods')->default(0);
            $table->boolean('R_goods')->default(0);
            $table->boolean('U_goods')->default(0);
            $table->boolean('D_goods')->default(0);

            $table->boolean('C_units')->default(0);
            $table->boolean('R_units')->default(0);
            $table->boolean('U_units')->default(0);
            $table->boolean('D_units')->default(0);

            $table->boolean('C_brands')->default(0);
            $table->boolean('R_brands')->default(0);
            $table->boolean('U_brands')->default(0);
            $table->boolean('D_brands')->default(0);

            $table->boolean('C_goodstype')->default(0);
            $table->boolean('R_goodstype')->default(0);
            $table->boolean('U_goodstype')->default(0);
            $table->boolean('D_goodstype')->default(0);

            $table->boolean('C_goodssubtype')->default(0);
            $table->boolean('R_goodssubtype')->default(0);
            $table->boolean('U_goodssubtype')->default(0);
            $table->boolean('D_goodssubtype')->default(0);

            $table->boolean('C_warehouse')->default(0);
            $table->boolean('R_warehouse')->default(0);
            $table->boolean('U_warehouse')->default(0);
            $table->boolean('D_warehouse')->default(0);

            $table->boolean('C_employee')->default(0);
            $table->boolean('R_employee')->default(0);
            $table->boolean('U_employee')->default(0);
            $table->boolean('D_employee')->default(0);

            $table->boolean('C_employeelevel')->default(0);
            $table->boolean('R_employeelevel')->default(0);
            $table->boolean('U_employeelevel')->default(0);
            $table->boolean('D_employeelevel')->default(0);

            $table->boolean('C_currency')->default(0);
            $table->boolean('R_currency')->default(0);
            $table->boolean('U_currency')->default(0);
            $table->boolean('D_currency')->default(0);

            $table->boolean('C_tax')->default(0);
            $table->boolean('R_tax')->default(0);
            $table->boolean('U_tax')->default(0);
            $table->boolean('D_tax')->default(0);

            $table->boolean('C_employeepayment')->default(0);
            $table->boolean('R_employeepayment')->default(0);
            $table->boolean('U_employeepayment')->default(0);
            $table->boolean('D_employeepayment')->default(0);

            $table->boolean('C_branch')->default(0);
            $table->boolean('R_branch')->default(0);
            $table->boolean('U_branch')->default(0);
            $table->boolean('D_branch')->default(0);

            $table->boolean('C_user')->default(0);
            $table->boolean('R_user')->default(0);
            $table->boolean('U_user')->default(0);
            $table->boolean('D_user')->default(0);

            $table->boolean('R_stockreport')->default(0);
            $table->boolean('R_salesreport')->default(0);
            $table->boolean('R_salesinvoicereport')->default(0);
            $table->boolean('R_arreport')->default(0);
            $table->boolean('R_arcustomerreport')->default(0);
            $table->boolean('R_purchasereport')->default(0);
            $table->boolean('R_apreport')->default(0);
            $table->boolean('R_stockvaluereport')->default(0);
            $table->boolean('R_journal')->default(0);
            $table->boolean('R_ledger')->default(0);
            $table->boolean('R_departement')->default(0);

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
        Schema::drop('roles');
    }
}
