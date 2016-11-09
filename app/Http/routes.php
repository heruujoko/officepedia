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

  Route::resource('mprefix','MPrefixController');

  Route::get('barang','MGoodsController@index');
  Route::get('barang/export/csv','MGoodsController@csv');
  Route::get('barang/export/excel','MGoodsController@excel');
  Route::get('barang/export/pdf','MGoodsController@pdf');

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

  Route::get('salesinvoice','SalesInvoiceController@index');

  Route::controllers([
    '/'=>'AdminController'
  ]);

});



  //API
  Route::group(['prefix'=>'admin-api','middleware' => 'api'],function(){
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
  Route::resource('msupplier','Api\MSupplierController');
  Route::get('mconfig','Api\MConfigController@index');
  Route::put('mconfig','Api\MConfigController@update');
  Route::put('mconfig/feature','Api\MConfigController@update_feature');
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
  Route::resource('mcategorycustomer','Api\MCategorycustomerController');
  Route::resource('mcategorysupplier','Api\MCategorysupplierController');
  Route::resource('mcategorygoods','Api\MCategorygoodsController');
  Route::resource('mcategoryfixedassets','Api\MCategoryfixedassetsController');
  Route::resource('mcategorygoodsmark','Api\MGoodsMarkController');
  Route::resource('memployeelevel','Api\MEmployeeLevelController');
  Route::resource('memployee','Api\MEmployeeController');
  Route::resource('mgoodsbrand','Api\MGoodsbrandController');
  Route::resource('mgoodstype','Api\MGoodstypeController');
  Route::resource('mgoodssubtype','Api\MGoodssubtypeController');
  Route::resource('munits','Api\MUnitController');
  Route::resource('mtax','Api\MTaxController');
  Route::resource('mwarehouse','Api\MWarehouseController');
  Route::resource('salesinvoice','Api\SalesInvoiceController');
  Route::controllers([
    '/'=>'ApiController'
  ]);

  Route::post('/editcabang/{id}','ApiController@postEditcabang');


});
