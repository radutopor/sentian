<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/cl', 'HomeController@classiffier');
Route::get('/tiby', array('before' => 'auth.basic', function () {
    //remove the double slashes and ; preceding them to have the test succeed
	return View::make('hello')->with('test','tiby');
}));

Route::controller('/service','ApiController');

//Config PAnel Routes
Route::get('/', 'LoginController@login');
Route::post('/signIn', 'LoginController@signIn');
Route::get('/signIn', 'LoginController@signIn');

Route::get('/servicelist', 'ConfigController@servicelist');
Route::get('/endpointlist', 'ConfigController@endpointlist');

// jquery Ajax url call
Route::get('/getServices', 'ConfigController@getServices');
Route::post('/updateService', 'ConfigController@updateService');
Route::post('/removeService', 'ConfigController@removeService');

Route::get('/getEndpointsAndServices', 'ConfigController@getEndpointsAndServices');
Route::post('/updateEndpoint', 'ConfigController@updateEndpoint');
Route::post('/removeEndpoint', 'ConfigController@removeEndpoint');


Route::get('/getParameters', 'ConfigController@getParameters');
Route::post('/updateParameters', 'ConfigController@updateParameters');


//test
//Route::get('/marius', 'HomeController@testAnalyzer');



