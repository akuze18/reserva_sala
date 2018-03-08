<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('getPisos','ApiController@getPisos')->name('getPisos');
Route::post('getSalas','ApiController@getSalas')->name('getSalas');
Route::post('getAsignaturas','ApiController@getAsignaturas')->name('getAsignaturas');
Route::post('getDisponibilidad','ApiController@getDisponibilidad')->name('getDisponibilidad');
