<?php


Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=>'admin-nano'],function(){

  Route::get('mcoagrandparent','MCOAGrandParentController@index');
  Route::get('mcoaparent','MCOAParentController@index');
  Route::resource('mcoa','MCOAController');
  Route::get('pelanggan','MCustomerController@index');
  
  Route::controllers([
  	'/'=>'AdminController'
  ]);

});


Route::group(['prefix'=>'admin-api',['middleware' => 'api']],function(){

  Route::resource('mcoagrandparent','Api\MCOAGrandParentController');
  Route::resource('mcoaparent','Api\MCOAParentController');
  Route::resource('mcoa','Api\MCOAController');

  Route::controllers([
  	'/'=>'ApiController'
  ]);

  Route::post('/editcabang/{id}','ApiController@postEditcabang');

});
