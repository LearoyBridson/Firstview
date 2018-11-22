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



Auth::routes();

Route::get('/', 'CompanyController@index');

Route::get('/addCompany', function () {
    return view('addCompany');
});

Route::get('/viewCompanies', 'CompanyController@index');

Route::get('/company/{id}', 'CompanyController@retrieve');
Route::post('/company', 'CompanyController@create');

Route::post('/company/{id}', 'CompanyController@createAsset');
