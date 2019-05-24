<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'DemografiController@index');

Route::get('/api/download/{id_bumn?}/{tahun?}/{periode?}', 'DemografiController@download');
Route::post('/api/import', 'DemografiController@import');
