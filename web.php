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

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Auth::routes();


Route::get('/addCompany', function () {
    return view('addCompany');
});


Route::get('/table/{table}/direction/{direction}/ID/{ID}/lastRowID/{lastID}', 'SelectController@getData');

Route::get('/', 'SelectController@selectUserCompanies');
Route::get('/company/{id}', 'SelectController@selectUserCompanyDetails');
Route::post('/insertCompany', 'InsertController@insertCompany')->middleware('validate.company');
Route::post('/insertAsset', 'InsertController@insertAsset')->middleware('validate.asset');
Route::post('/editCompany', 'UpdateController@updateCompany')->middleware('validate.companyUpdate');
Route::post('/deleteAsset', 'UpdateController@deleteAsset');
Route::post('/deleteCompany', 'UpdateController@deleteCompany');