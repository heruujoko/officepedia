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
          'msysprefixgoodslastcount' => '00',
          'msysprefixsupplier' => 'SPL',
          'msysprefixsuppliercount' => 1,
          'msysprefixsupplierlastcount' => '001',
          'msysprefixcustomer' => 'CUS',
          'msysprefixcustomercount' => 0,
          'msysprefixcustomerlastcount' => '00',
          'msysprefixemployee' => 'EMP',
          'msysprefixemployeecount' => 0,
          'msysprefixemployeelastcount' => '00',
          'msysprefixinvquotation' => 'INQ',
          'msysprefixinvquotationcount' => 0,
          'msysprefixinvquotationlastcount' => '00',
          'msysprefixinvorder' => 'ORD',
          'msysprefixinvordercount' => 0,
          'msysprefixinvorderlastcount' => '00',
          'msysprefixinvoice' => 'INV',
          'msysprefixinvoicecount' => 0,
          'msysprefixinvoicelastcount' => '00',
          'msysprefixpurchrequest' => 'PUR',
          'msysprefixpurchrequestcount' => 0,
          'msysprefixpurchrequestlastcount' => '00',
          'msysprefixpurchorder' => 'POR',
          'msysprefixpurchordercount' => 0,
          'msysprefixpurchorderlastcount' => '00',
          'msysprefixpurchinv' => 'PIN',
          'msysprefixpurchinvcount' => 0,
          'msysprefixpurchinvlastcount' => '00',
          'msysprefixedasset' => 'AST',
          'msysprefixedassetcount' => 0,
          'msysprefixedassetlastcount' => '00',
          'msysprefixcashreceipt' => 'CRP',
          'msysprefixcashreceiptcount' => 0,
          'msysprefixcashreceiptlastcount' => '00',
          'msysprefixcashout' => 'COT',
          'msysprefixcashoutcount' => 0,
          'msysprefixcashoutlastcount' => '00',
          'msysprefixbankrecon' => 'REC',
          'msysprefixbankreconcount' => 0,
          'msysprefixbankreconlastcount' => '00',
          'msysprefixpayap' => 'PAP',
          'msysprefixpayapcount' => 0,
          'msysprefixpayaplastcount' => '00',
          'msysprefixpayar' => 'PAR',
          'msysprefixpayarcount' => 0,
          'msysprefixpayarlastcount' => '00',
          'msysprefixpurchasequotation' => 'PQU',
          'msysprefixpurchasequotationcount' => 0,
          'msysprefixinvoicequotationlastcount' => '00',
          'msysprefixinvoicequotation' => 'IQU',
          'msysprefixinvoicequotationcount' => 0,
          'msysprefixinvoicequotationlastcount' => '00',
          'msyspayapaccount' => '2101.03',
          'msyspayaraccount' => '1103.02',
          'msysprefixjournal' => 'JUR',
          'msysprefixjournalcount' => 0,
          'msysprefixjournallastcount' => '00',
          'msysacccogmethod' => 'average',
          'msysaccstock' => '1105.01',
          'msysaccinv' => '4100.01',
          'msysaccreturninv' => '4100.04',
          'msysaccinvdisc' => '4100.05',
          'msysaccsellingexpense' => '5100.01',
          'msysaccreturnpurchase' => '5100.05',
          'msysaccpaidcapital' => '3100.02',
          'msysaccretainedearning' => '3200.01'
        ]);
    }
}
