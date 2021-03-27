<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/temp', function () {

   
    // if (password_verify($x, '$2y$10$IEnKUvIXlXeeuOY6R0NqkuTr1ovoYrdUP.jnnO3gnSp7q76dXcK3K')) {
    //     echo 'Password is valid!';
    // } else {
    //     echo 'Invalid password.';
    // }

});



//Report
Route::prefix('report')->group(function () 
{
    Route::get('index', 'ReportController@index')->name('index-report');
    Route::get('create', 'ReportController@create')->name('create-report');
    Route::post('store', 'ReportController@store')->name('store-report');
    Route::get('show/{id}', 'ReportController@show')->name('show-report'); 
    Route::get('edit/{id}', 'ReportController@edit')->name('edit-report'); 
    Route::post('update/{id}', 'ReportController@update')->name('update-report'); 
    Route::post('destroy/{id}', 'ReportController@destroy')->name('destroy-report'); 
});
//////////////////////////////////////////////////////////////////////
Route::prefix('report-files')->group(function () 
{
    Route::get('index/{id}', 'ReportFileController@index')->name('index-report-file');
    Route::post('store/{id}', 'ReportFileController@store')->name('store-report-file');
    Route::post('destroy/{id}', 'ReportFileController@destroy')->name('destroy-report-file');
});

////////////////////////////////////////////////////////////////////
Route::prefix('user')->middleware('can:manage-users')->group(function () 
{
    Route::get('index', 'UserController@index')->name('index-user');
    Route::get('create', 'UserController@create')->name('create-user');
    Route::get('edit/{user}', 'UserController@edit')->name('edit-user');
    Route::post('store', 'UserController@store')->name('store-user');
    Route::post('update/{user}', 'UserController@update')->name('update-user');
    Route::post('destroy/{user}', 'UserController@destroy')->name('destroy-user');
});

//////////////////////////////////////////////////////////////////////////

Route::prefix('search')->group(function () 
{
    Route::get('index', 'SearchController@index')->name('index-search');
    Route::get('search', 'SearchController@search')->name('search');
});

////////////////////////////////////////////////////////////////////
Route::prefix('group')->middleware('can:manage-groups')->group(function () 
{
    Route::get('index', 'GroupController@index')->name('index-group');
    Route::post('store', 'GroupController@store')->name('store-group');
    Route::post('destroy/{group}', 'GroupController@destroy')->name('destroy-group');
});

////////////////////////////////////////////////////////////////////
Auth::routes(['register' => false ,'password.confirm' => false]);

// Route::get('/home', 'HomeController@index')->name('home');
