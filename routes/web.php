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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'Admin\HomeController@index')->name('/');
Route::get('/hotel-link', 'Admin\HomeController@hotelLink')->name('hotel-link');
Route::get('/resize-and-download', 'Admin\HomeController@resizeAndDownload')->name('resize-and-download');