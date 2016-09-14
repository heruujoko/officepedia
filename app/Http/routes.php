<?php


Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=>'admin-nano'],function(){

  Route::get('mcoagrandparent','MCOAGrandParentController@index');

  Route::controllers([
  	'/'=>'AdminController'
  ]);

});


Route::group(['prefix'=>'admin-api',['middleware' => 'api']],function(){

  Route::resource('mcoagrandparent','Api\MCOAGrandParentController');

  Route::controllers([
  	'/'=>'ApiController'
  ]);

  Route::post('/editcabang/{id}','ApiController@postEditcabang');

});
