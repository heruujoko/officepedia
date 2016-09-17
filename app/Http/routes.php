<?php


Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=>'admin-nano'],function(){

  Route::get('mcoagrandparent','MCOAGrandParentController@index');
  Route::get('mcoaparent','MCOAParentController@index');
  Route::resource('mcoa','MCOAController');
// <<<<<<< HEAD
  Route::get('pelanggan','MCustomerController@index');
  
// =======
  Route::resource('mprefix','MPrefixController');

// >>>>>>> c927e24266c47558ae89e3d0b982392ba4126912
  Route::controllers([
  	'/'=>'AdminController'
  ]);

});


Route::group(['prefix'=>'admin-api',['middleware' => 'api']],function(){

  Route::resource('cabang', 'Api\MBranchController');
  Route::resource('mcoagrandparent','Api\MCOAGrandParentController');
  Route::resource('mcoaparent','Api\MCOAParentController');
  Route::resource('mcoa','Api\MCOAController');
  Route::resource('mprefix','Api\MPrefixController');

  Route::controllers([
  	'/'=>'ApiController'
  ]);

  Route::post('/editcabang/{id}','ApiController@postEditcabang');

});
