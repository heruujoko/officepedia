<?php


Route::get('/', function () {
    return redirect('login');
});


Route::get('register','AuthController@register');
Route::post('signup','AuthController@signup');
Route::get('login','AuthController@login');
Route::post('login','AuthController@auth');
Route::get('logout','AuthController@logout');

Route::group(['prefix'=>'admin-nano','middleware' => ['auth','tenantdb']],function(){
  // Route::get('/','AdminController@dashboard');
  Route::get('mcoagrandparent','MCOAGrandParentController@index');
  Route::get('mcoa/export/print','MCOAController@xprint');
  Route::get('mcoa/export/pdf','MCOAController@pdf');
  Route::get('mcoa/export/excel','MCOAController@excel');
  Route::get('mcoa/export/csv','MCOAController@csv');
  Route::get('mcoaparent','MCOAParentController@index');
  Route::resource('mcoa','MCOAController');

  Route::resource('generaljournal','GeneralJournalController');

  Route::get('pelanggan','MCustomerController@index');
  Route::get('pelanggan/export/csv','MCustomerController@csv');
  Route::get('pelanggan/export/excel','MCustomerController@excel');
  Route::get('pelanggan/export/pdf','MCustomerController@pdf');
  Route::get('pelanggan/insert/{id}/{activetab}','MCustomerController@editmcustomercontact');

  Route::get('mprefix/export/csv','MPrefixController@csv');
  Route::get('mprefix/export/excel','MPrefixController@excel');
  Route::get('mprefix/export/pdf','MPrefixController@pdf');

  Route::get('cabang/export/csv','MBranchController@csv');
  Route::get('cabang/export/excel','MBranchController@excel');
  Route::get('cabang/export/pdf','MBranchController@pdf');

  Route::get('msupplier','MSupplierController@index');
  Route::get('msupplier/export/csv','MSupplierController@csv');
  Route::get('msupplier/export/excel','MSupplierController@excel');
  Route::get('msupplier/export/pdf','MSupplierController@pdf');
  Route::get('msupplier/insert/{id}/{activetab}','MSupplierController@editmsuppliercontact');

  Route::get('mconfig/sysparam','MConfigController@sysparam');
  Route::get('mconfig/sysfeature','MConfigController@sysfeature');
  Route::get('cashbank/list','CashBankListController@index');

  Route::get('cashbank/cash/export/csv','CashBankListController@csv');
  Route::get('cashbank/cash/export/excel','CashBankListController@excel');
  Route::get('cashbank/cash/export/pdf','CashBankListController@pdf');

  Route::get('cashbank/bank/export/csv','CashBankListController@csv_bank');
  Route::get('cashbank/bank/export/excel','CashBankListController@excel_bank');
  Route::get('cashbank/bank/export/pdf','CashBankListController@pdf_bank');

  Route::get('cashbank/income','CashBankIncomeController@index');
  Route::get('cashbank/outcome','CashBankOutcomeController@index');
  Route::get('cashbank/transfer','CashBankTransferController@index');

  Route::resource('mprefix','MPrefixController');

  Route::get('barang','MGoodsController@index');
  Route::get('barang/export/csv','MGoodsController@csv');
  Route::get('barang/export/excel','MGoodsController@excel');
  Route::get('barang/export/pdf','MGoodsController@pdf');
  Route::get('barang/export/pricelist','MGoodsController@pricelist');

  Route::get('mcategorycustomer','MCategorycustomerController@index');
  Route::get('mcategorycustomer/export/csv','MCategorycustomerController@csv');
  Route::get('mcategorycustomer/export/excel','MCategorycustomerController@excel');
  Route::get('mcategorycustomer/export/pdf','MCategorycustomerController@pdf');

  Route::get('mcategorysupplier','MCategorysupplierController@index');
  Route::get('mcategorysupplier/export/csv','MCategorysupplierController@csv');
  Route::get('mcategorysupplier/export/excel','MCategorysupplierController@excel');
  Route::get('mcategorysupplier/export/pdf','MCategorysupplierController@pdf');

  Route::get('mcategorygoods','MCategorygoodsController@index');
  Route::get('mcategorygoods/export/csv','MCategorygoodsController@csv');
  Route::get('mcategorygoods/export/excel','MCategorygoodsController@excel');
  Route::get('mcategorygoods/export/pdf','MCategorygoodsController@pdf');

  Route::get('mcategoryfixedassets','MCategoryfixedassetsController@index');
  Route::get('mcategoryfixedassets/export/csv','MCategoryfixedassetsController@csv');
  Route::get('mcategoryfixedassets/export/excel','MCategoryfixedassetsController@excel');
  Route::get('mcategoryfixedassets/export/pdf','MCategoryfixedassetsController@pdf');

  Route::get('mpurchasefixedassets','MHPurchaseFixedAssetController@index');

  Route::get('mcategorygoodsmark','MGoodsMarkController@index');
  Route::get('mcategorygoodsmark/export/csv','MGoodsMarkController@csv');
  Route::get('mcategorygoodsmark/export/excel','MGoodsMarkController@excel');
  Route::get('mcategorygoodsmark/export/pdf','MGoodsMarkController@pdf');

  Route::get('memployeelevel','MEmployeeLevelController@index');
  Route::get('memployeelevel/export/csv','MEmployeeLevelController@csv');
  Route::get('memployeelevel/export/excel','MEmployeeLevelController@excel');
  Route::get('memployeelevel/export/pdf','MEmployeeLevelController@pdf');

  Route::get('memployee','MEmployeeController@index');
  Route::get('memployee/export/csv','MEmployeeController@csv');
  Route::get('memployee/export/excel','MEmployeeController@excel');
  Route::get('memployee/export/pdf','MEmployeeController@pdf');

  Route::get('mgoodsbrand','MGoodsbrandController@index');
  Route::get('mgoodsbrand/export/csv','MGoodsbrandController@csv');
  Route::get('mgoodsbrand/export/excel','MGoodsbrandController@excel');
  Route::get('mgoodsbrand/export/pdf','MGoodsbrandController@pdf');

  Route::get('mgoodstype','MGoodstypeController@index');
  Route::get('mgoodstype/export/csv','MGoodstypeController@csv');
  Route::get('mgoodstype/export/excel','MGoodstypeController@excel');
  Route::get('mgoodstype/export/pdf','MGoodstypeController@pdf');

  Route::get('mgoodssubtype','MGoodssubtypeController@index');
  Route::get('mgoodssubtype/export/csv','MGoodssubtypeController@csv');
  Route::get('mgoodssubtype/export/excel','MGoodssubtypeController@excel');
  Route::get('mgoodssubtype/export/pdf','MGoodssubtypeController@pdf');

  Route::get('munits','MUnitController@index');
  Route::get('munits/export/csv','MUnitController@csv');
  Route::get('munits/export/excel','MUnitController@excel');
  Route::get('munits/export/pdf','MUnitController@pdf');

  Route::get('mtax','MTaxController@index');
  Route::get('mtax/export/csv','MTaxController@csv');
  Route::get('mtax/export/excel','MTaxController@excel');
  Route::get('mtax/export/pdf','MTaxController@pdf');

  Route::get('mwarehouse','MWarehouseController@index');
  Route::get('mwarehouse/export/csv','MWarehouseController@csv');
  Route::get('mwarehouse/export/excel','MWarehouseController@excel');
  Route::get('mwarehouse/export/pdf','MWarehouseController@pdf');

  Route::get('salesinvoice/{invoiceno}/lpt','SalesInvoiceController@lptPrint');
  Route::get('salesinvoice','SalesInvoiceController@index');
  Route::get('salesinvoice/export/csv','SalesInvoiceController@csv');
  Route::get('salesinvoice/export/excel','SalesInvoiceController@excel');
  Route::get('salesinvoice/export/pdf','SalesInvoiceController@pdf');

  Route::get('salesquotation','SalesquotationController@index');
  Route::get('salesquotation/export/csv','SalesquotationController@csv');
  Route::get('salesquotation/export/excel','SalesquotationController@excel');
  Route::get('salesquotation/export/pdf','SalesquotationController@pdf');
  Route::get('salesquotation/export/print2/{mhpurchasequotationno}','SalesquotationController@print2');


  Route::get('purchaseinvoice','PurchaseController@index');
  Route::get('purchaseinvoice/export/csv','PurchaseController@csv');
  Route::get('purchaseinvoice/export/excel','PurchaseController@excel');
  Route::get('purchaseinvoice/export/pdf','PurchaseController@pdf');

  Route::get('purchasequotation','PurchasequotationController@index');
  Route::get('purchasequotation/export/csv','PurchasequotationController@csv');
  Route::get('purchasequotation/export/excel','PurchasequotationController@excel');
  Route::get('purchasequotation/export/pdf','PurchasequotationController@pdf');
  Route::get('purchasequotation/export/print2/{mhpurchasequotationno}','PurchasequotationController@print2');

  Route::get('payap','PayApController@payap');
  Route::get('payap/export/csv','PayApController@payap_csv');
  Route::get('payap/export/excel','PayApController@payap_excel');
  Route::get('payap/export/pdf','PayApController@payap_pdf');

  Route::get('payar','PayArController@payar');
  Route::get('payar/export/csv','PayArController@payar_csv');
  Route::get('payar/export/excel','PayArController@payar_excel');
  Route::get('payar/export/pdf','PayArController@payar_pdf');

  Route::get('muser','MUserController@index');
  Route::get('muser/export/csv','MUserController@csv');
  Route::get('muser/export/excel','MUserController@excel');
  Route::get('muser/export/pdf','MUserController@pdf');


  Route::get('mstockcardreport','MStockcardreportController@index');
  // Route::get('mstockcardreport','MStockcardreportController@csv');
  // Route::get('mstockcardreport','MStockcardreportController@excel');
  // Route::get('mstockcardreport','MStockcardreportController@pdf');


  Route::get('reports/salesreport','ReportController@salesreport');
  Route::get('reports/salesreport/export/print','ReportController@salesreport_print');
  Route::get('reports/salesreport/export/pdf','ReportController@salesreport_pdf');
  Route::get('reports/salesreport/export/excel','ReportController@salesreport_excel');
  Route::get('reports/salesreport/export/csv','ReportController@salesreport_csv');

  Route::get('reports/invoicereport','ReportController@invoicereport');
  Route::get('reports/invoicereport/export/print','ReportController@invoicereport_print');
  Route::get('reports/invoicereport/export/pdf','ReportController@invoicereport_pdf');
  Route::get('reports/invoicereport/export/excel','ReportController@invoicereport_excel');
  Route::get('reports/invoicereport/export/csv','ReportController@invoicereport_csv');

  Route::get('reports/arreport','ReportController@arreport');
  Route::get('reports/arreport/export/print','ReportController@arreport_print');
  Route::get('reports/arreport/export/pdf','ReportController@arreport_pdf');
  Route::get('reports/arreport/export/excel','ReportController@arreport_excel');
  Route::get('reports/arreport/export/csv','ReportController@arreport_csv');

  Route::get('reports/arcustreport','ReportController@arcustreport');
  Route::get('reports/arcustreport/export/print','ReportController@arcustreport_print');
  Route::get('reports/arcustreport/export/pdf','ReportController@arcustreport_pdf');
  Route::get('reports/arcustreport/export/excel','ReportController@arcustreport_excel');
  Route::get('reports/arcustreport/export/csv','ReportController@arcustreport_csv');

  Route::get('reports/stockreport/export/print','ReportController@stockreport_print');
  Route::get('reports/stockreport/export/pdf','ReportController@stockreport_pdf');
  Route::get('reports/stockreport/export/excel','ReportController@stockreport_excel');
  Route::get('reports/stockreport/export/csv','ReportController@stockreport_csv');

  Route::get('reports/purchasereport','PurchaseReportController@purchasereport');
  Route::get('reports/purchasereport/export/print','PurchaseReportController@purchasereport_print');
  Route::get('reports/purchasereport/export/pdf','PurchaseReportController@purchasereport_pdf');
  Route::get('reports/purchasereport/export/excel','PurchaseReportController@purchasereport_excel');
  Route::get('reports/purchasereport/export/csv','PurchaseReportController@purchasereport_csv');

  Route::get('reports/stockvalue','StockValueReportController@stockvalue');
  Route::get('reports/stockvalue/export/print','StockValueReportController@stockvalue_print');
  Route::get('reports/stockvalue/export/pdf','StockValueReportController@stockvalue_pdf');
  Route::get('reports/stockvalue/export/excel','StockValueReportController@stockvalue_excel');
  Route::get('reports/stockvalue/export/csv','StockValueReportController@stockvalue_csv');

  Route::get('reports/apreport','APReportController@apreport');
  Route::get('reports/apreport/export/print','APReportController@apreport_print');
  Route::get('reports/apreport/export/pdf','APReportController@apreport_pdf');
  Route::get('reports/apreport/export/excel','APReportController@apreport_excel');
  Route::get('reports/apreport/export/csv','APReportController@apreport_csv');

  Route::get('reports/cogshistory','COGSHistoryController@cogshistory');
  Route::get('reports/cogshistory/export/print','COGSHistoryController@cogshistory_print');
  Route::get('reports/cogshistory/export/pdf','COGSHistoryController@cogshistory_pdf');
  Route::get('reports/cogshistory/export/excel','COGSHistoryController@cogshistory_excel');
  Route::get('reports/cogshistory/export/csv','COGSHistoryController@cogshistory_csv');

  Route::get('reports/journal','JournalController@journal');
  Route::get('reports/journal/export/print','JournalController@journal_print');
  Route::get('reports/journal/export/pdf','JournalController@journal_pdf');
  Route::get('reports/journal/export/excel','JournalController@journal_excel');
  Route::get('reports/journal/export/csv','JournalController@journal_csv');

  Route::get('reports/ledger','LedgerController@ledger');
  Route::get('reports/ledger/export/print','LedgerController@ledger_print');
  Route::get('reports/ledger/export/pdf','LedgerController@ledger_pdf');
  Route::get('reports/ledger/export/excel','LedgerController@ledger_excel');
  Route::get('reports/ledger/export/csv','LedgerController@ledger_csv');

  Route::get('reports/arbook','ARBookController@index');
  Route::get('reports/arbook/export/print','ARBookController@arbook_print');
  Route::get('reports/arbook/export/pdf','ARBookController@arbook_pdf');
  Route::get('reports/arbook/export/excel','ARBookController@arbook_excel');
  Route::get('reports/arbook/export/csv','ARBookController@arbook_csv');

  Route::get('reports/purchasejournal','PurchaseJournalController@index');
  Route::get('reports/purchasejournal/export/print','PurchaseJournalController@purchasejournal_print');
  Route::get('reports/purchasejournal/export/pdf','PurchaseJournalController@purchasejournal_pdf');
  Route::get('reports/purchasejournal/export/excel','PurchaseJournalController@purchasejournal_excel');
  Route::get('reports/purchasejournal/export/csv','PurchaseJournalController@purchasejournal_csv');

  Route::get('reports/salesjournal','SalesJournalController@index');
  Route::get('reports/salesjournal/export/print','SalesJournalController@salesjournal_print');
  Route::get('reports/salesjournal/export/pdf','SalesJournalController@salesjournal_pdf');
  Route::get('reports/salesjournal/export/excel','SalesJournalController@salesjournal_excel');
  Route::get('reports/salesjournal/export/csv','SalesJournalController@salesjournal_csv');

  Route::get('reports/cashbalance','CashBalanceReport@index');
  Route::get('reports/cashbalance/export/print','CashBalanceReport@cashbalance_print');
  Route::get('reports/cashbalance/export/pdf','CashBalanceReport@cashbalance_pdf');
  Route::get('reports/cashbalance/export/excel','CashBalanceReport@cashbalance_excel');
  Route::get('reports/cashbalance/export/csv','CashBalanceReport@cashbalance_csv');

  Route::get('reports/expenses','ExpensesController@index');
  Route::get('reports/expenses/export/print','ExpensesController@expenses_print');
  Route::get('reports/expenses/export/pdf','ExpensesController@expenses_pdf');
  Route::get('reports/expenses/export/excel','ExpensesController@expenses_excel');
  Route::get('reports/expenses/export/csv','ExpensesController@expenses_csv');

  Route::get('roles','RoleController@index');
  Route::get('roles/export/print','RoleController@roles_print');
  Route::get('roles/export/pdf','RoleController@roles_pdf');
  Route::get('roles/export/excel','RoleController@roles_excel');
  Route::get('roles/export/csv','RoleController@roles_csv');

  Route::get('mdepartement','MDepartementController@index');
  Route::get('mdepartement/export/csv','MDepartementController@csv');
  Route::get('mdepartement/export/excel','MDepartementController@excel');
  Route::get('mdepartement/export/pdf','MDepartementController@pdf');

  Route::controllers([
    '/'=>'AdminController'
  ]);

});



  //API
  Route::group(['prefix'=>'admin-api','middleware' => 'jwt'],function(){
  Route::get('mcoa/tree','Api\MCOAController@tree');
  Route::resource('cabang', 'Api\MBranchController');
  Route::get('mcoagrandparent/lists','Api\MCOAGrandParentController@lists');
  Route::get('mcoaparent/lists','Api\MCOAParentController@lists');
  Route::resource('mcoagrandparent','Api\MCOAGrandParentController');
  Route::resource('mcoaparent','Api\MCOAParentController');
  Route::resource('mcoa','Api\MCOAController');
  Route::resource('mprefix','Api\MPrefixController');
  Route::get('pelanggan/datalist','Api\MCustomerController@datalist');
  Route::resource('pelanggan','Api\MCustomerController');
  Route::get('msupplier/datalist','Api\MSupplierController@datalist');
  Route::resource('msupplier','Api\MSupplierController');
  Route::get('mconfig','Api\MConfigController@index');
  Route::put('mconfig','Api\MConfigController@update');
  Route::put('mconfig/feature','Api\MConfigController@update_feature');
  Route::get('barang/datalist','Api\MGoodsController@datalist');
  Route::get('barang/purchasedatalist','Api\MGoodsController@datalist');
  Route::get('barang/salesdatalist','Api\MGoodsController@salesdatalist');
  Route::get('barang/purchasedatalist','Api\MGoodsController@purchasedatalist');
  Route::get('barang/pkp','Api\MGoodsController@pkp');
  Route::post('barang/import','Api\MGoodsController@importGoods');
  Route::post('barang/importprice','Api\MGoodsController@importGoodsPrice');
  Route::resource('barang','Api\MGoodsController');
  Route::post('mconfig/logo','Api\MConfigController@logo');
  Route::post('barang/gambar','Api\MGoodsController@gambar');
  Route::get('cashbank/cash','Api\CashBankListController@cash');
  Route::post('cashbank/cash','Api\CashBankListController@add_cash');
  Route::put('cashbank/cash/{id}','Api\CashBankListController@update_cash');
  Route::get('cashbank/bank','Api\CashBankListController@bank');
  Route::post('cashbank/bank','Api\CashBankListController@add_bank');
  Route::put('cashbank/bank/{id}','Api\CashBankListController@update_bank');
  Route::get('cashbank/total/{code}','Api\CashBankListController@total');
  Route::get('cashbank/grandtotal','Api\CashBankListController@grand_total');

  Route::resource('cashbank/income','Api\CashBankIncomeController');
  Route::get('cashbank/income/header/{id}','Api\CashBankIncomeController@header');
  Route::get('cashbank/detailincome/{journalid}','Api\CashBankIncomeController@details');

  Route::resource('cashbank/outcome','Api\CashBankOutcomeController');
    Route::get('cashbank/outcome/header/{id}','Api\CashBankOutcomeController@header');
  Route::get('cashbank/detailoutcome/{journalid}','Api\CashBankOutcomeController@details');

    Route::resource('cashbank/transfer','Api\CashBankTransferController');
    Route::get('cashbank/transfer/header/{id}','Api\CashBankTransferController@header');
    Route::get('cashbank/detailtransfer/{journalid}','Api\CashBankTransferController@details');

  Route::resource('purchasefixedasset/{id}/details','Api\MHPurchaseFixedAssetController@details');
  Route::resource('purchasefixedasset','Api\MHPurchaseFixedAssetController');


  Route::resource('mcategorycustomer','Api\MCategorycustomerController');
  Route::resource('mcategorysupplier','Api\MCategorysupplierController');
  Route::resource('mcategorygoods','Api\MCategorygoodsController');
  Route::resource('mcategoryfixedassets/data','Api\MCategoryfixedassetsController@data');
  Route::resource('mcategoryfixedassets','Api\MCategoryfixedassetsController');
  Route::resource('mcategorygoodsmark','Api\MGoodsMarkController');
  Route::resource('memployeelevel','Api\MEmployeeLevelController');
  Route::resource('memployee','Api\MEmployeeController');
  Route::resource('mgoodsbrand','Api\MGoodsbrandController');
  Route::resource('mgoodstype','Api\MGoodstypeController');
  Route::resource('mgoodssubtype','Api\MGoodssubtypeController');
  Route::resource('munits','Api\MUnitController');
  Route::resource('mtax/datalist','Api\MTaxController@datalist');
  Route::resource('mtax','Api\MTaxController');
  Route::get('mwarehouse/datalist','Api\MWarehouseController@datalist');
  Route::resource('mwarehouse','Api\MWarehouseController');
  Route::get('salesinvoice/details/{inv}','Api\SalesInvoiceController@details');
  Route::resource('salesinvoice','Api\SalesInvoiceController');

  Route::get('salesquotation/details/{inv}','Api\SalesquotationController@details');
  Route::resource('salesquotation','Api\SalesquotationController');

  Route::get('purchaseinvoice/details/{inv}','Api\PurchaseController@details');
  Route::resource('purchaseinvoice','Api\PurchaseController');
  Route::resource('muser','Api\MUserController');
  Route::resource('purchasequotation','Api\PurchasequotationController');
  Route::get('purchasequotation/details/{inv}','Api\PurchasequotationController@details');

  Route::get('mstockcardreport','Api\MStockcardreportController@filter');

  Route::get('mstockcardreport/mgoods','Api\MStockcardreportController@mgoods');
  Route::get('mstockcardreport/mwarehouse','Api\MStockcardreportController@mwarehouse');

  Route::get('salesreport','Api\SalesController@index');
  Route::get('salesreport/detail/{invoice_no}','Api\SalesController@invoice_detail');
  Route::get('invoicereport','Api\SalesController@invoices');
  Route::get('arreport','Api\SalesController@ar');
  Route::get('arcustreport','Api\SalesController@arcust');
  Route::get('arcustreport/details/{customer_id}','Api\SalesController@arcust_detail');
  Route::get('stockvalues','Api\StockValueController@index');
  Route::get('purchasereport','Api\PurchaseController@purchasereport');
  Route::get('apreport','Api\APController@apreport');
  Route::get('cogshistory','Api\COGSHistoryController@index');

  Route::get('apdata','Api\APController@apdata');
  Route::get('apsupplier/{id}','Api\APController@apsupplier');
  Route::get('ap/{id}','Api\APController@show');
  Route::get('coadata','Api\MCOAController@datalist');
  Route::get('coadata/all','Api\MCOAController@alldatalist');
  Route::get('coadata/{parentcode}','Api\MCOAController@datalistaccount');
  Route::resource('payap','Api\PayApController');
  Route::get('payap/details/{invoice_no}','Api\PayApController@details');

  Route::get('ardata','Api\ARController@ardata');
  Route::get('arcustomer/{id}','Api\ARController@arcustomer');
  Route::get('ar/{id}','Api\ARController@show');
  Route::resource('payar','Api\PayArController');
  Route::get('payar/details/{invoice_no}','Api\PayArController@details');

  Route::get('journal/types','Api\JournalController@trans_types');
  Route::get('journal','Api\JournalController@journal');
  Route::get('journal/group/{type}','Api\JournalController@group_journal');
  Route::get('coaledger','Api\MCOAController@datalistledger');
  Route::get('coaexpenses','Api\MCOAController@datalistexpenses');
  Route::get('ledgers','Api\LedgerController@ledgers');
  Route::resource('generaljournal','Api\GeneralJournalController');
  Route::resource('roles','Api\RoleController');

  Route::get('profile/branch','Api\ProfileController@mybranch');
  Route::get('profile/defaultbranch','Api\ProfileController@default_branch');
  Route::post('profile/defaultbranch','Api\ProfileController@update_default_branch');

  Route::get('arbook','Api\ARBookController@index');
  Route::get('arbook/details/{customer_id}','Api\ARBookController@details');

  Route::get('purchasejournal','Api\PurchaseJournalController@index');
  Route::get('salesjournal','Api\SalesJournalController@index');
  Route::get('cashbalance','Api\CashBalanceReport@index');

  Route::get('mdepartment/datalist','Api\MDepartementController@datalist');
  Route::resource('mdepartement','Api\MDepartementController');

  Route::controllers([
    '/'=>'ApiController'
  ]);

  Route::post('/editcabang/{id}','ApiController@postEditcabang');


});
