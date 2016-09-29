<?php


Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=>'admin-nano'],function(){

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
  Route::resource('mprefix','MPrefixController');
  Route::controllers([
  	'/'=>'AdminController'
  ]);

});


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
  Route::controllers([
  	'/'=>'ApiController'
  ]);

  Route::post('/editcabang/{id}','ApiController@postEditcabang');


});
