<?php


Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=>'admin-nano'],function(){
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
  Route::controllers([
    '/'=>'AdminController'
  ]);

});


  
  //API
  Route::group(['prefix'=>'admin-api',['middleware' => 'api']],function(){
  Route::get('mcoa/tree','Api\MCOAController@tree');

  Route::resource('cabang', 'Api\MBranchController');
  Route::get('mcoagrandparent/lists','Api\MCOAGrandParentController@lists');
  Route::get('mcoaparent/lists','Api\MCOAParentController@lists');
  Route::resource('mcoagrandparent','Api\MCOAGrandParentController');
  Route::resource('mcoaparent','Api\MCOAParentController');
  Route::resource('mcoa','Api\MCOAController');
  Route::resource('mprefix','Api\MPrefixController');
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

  Route::controllers([
    '/'=>'ApiController'
  ]);

  Route::post('/editcabang/{id}','ApiController@postEditcabang');


});
