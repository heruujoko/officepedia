<?php


Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix'=>'admin-nano'],function(){

Route::controllers([
	'/'=>'AdminController'

]);

});


Route::group(['prefix'=>'admin-api',['middleware' => 'api']],function(){

Route::controllers([
	'/'=>'ApiController'

]);
Route::post('/editcabang/{id}','ApiController@postEditcabang');

});