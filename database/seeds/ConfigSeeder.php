<?php

use Illuminate\Database\Seeder;
use App\MConfig;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MConfig::create([
          'msyscompname' => 'Sample Company',
          'msysgenrounddec' => 0,
          'msysnumseparator' => ',',
          'msysprefixgoods' => 'BRG',
          'msysprefixgoodscount' => 0,
          'msysprefixgoodslastcount' => '00000000000',
          'msysprefixsupplier' => 'SPL',
          'msysprefixsuppliercount' => 1,
          'msysprefixsupplierlastcount' => '000001',
          'msysprefixcustomer' => 'CUS',
          'msysprefixcustomercount' => 0,
          'msysprefixcustomerlastcount' => '000000',
          'msysprefixemployee' => 'EMP',
          'msysprefixemployeecount' => 0,
          'msysprefixemployeelastcount' => '000000',
          'msysprefixinvquotation' => 'INQ',
          'msysprefixinvquotationcount' => 0,
          'msysprefixinvquotationlastcount' => '000000',
          'msysprefixinvorder' => 'ORD',
          'msysprefixinvordercount' => 0,
          'msysprefixinvorderlastcount' => '000000',
          'msysprefixinvoice' => 'INV',
          'msysprefixinvoicecount' => 0,
          'msysprefixinvoicelastcount' => '000000',
          'msysprefixpurchrequest' => 'PUR',
          'msysprefixpurchrequestcount' => 0,
          'msysprefixpurchrequestlastcount' => '000000',
          'msysprefixpurchorder' => 'POR',
          'msysprefixpurchordercount' => 0,
          'msysprefixpurchorderlastcount' => '000000',
          'msysprefixpurchinv' => 'PIN',
          'msysprefixpurchinvcount' => 0,
          'msysprefixpurchinvlastcount' => '000000',
          'msysprefixedasset' => 'AST',
          'msysprefixedassetcount' => 0,
          'msysprefixedassetlastcount' => '000000',
          'msysprefixcashreceipt' => 'CRP',
          'msysprefixcashreceiptcount' => 0,
          'msysprefixcashreceiptlastcount' => '000000',
          'msysprefixcashout' => 'COT',
          'msysprefixcashoutcount' => 0,
          'msysprefixcashoutlastcount' => '000000',
          'msysprefixbankrecon' => 'REC',
          'msysprefixbankreconcount' => 0,
          'msysprefixbankreconlastcount' => '000000',
          'msysprefixpayap' => 'PAP',
          'msysprefixpayapcount' => 0,
          'msysprefixpayaplastcount' => '000000',
          'msysprefixpayar' => 'PAR',
          'msysprefixpayarcount' => 0,
          'msysprefixpayarlastcount' => '000000',
          'msysprefixpurchasequotation' => 'PQU',
          'msysprefixpurchasequotationcount' => 0,
          'msysprefixinvoicequotationlastcount' => '000000',
          'msysprefixinvoicequotation' => 'IQU',
          'msysprefixinvoicequotationcount' => 0,
          'msysprefixinvoicequotationlastcount' => '000000',
          'msyspayapaccount' => '2101.03',
          'msyspayaraccount' => '1103.02'
        ]);
    }
}
