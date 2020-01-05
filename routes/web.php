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

Route::get('/', function () {
    return redirect('contact');
});
Route::resource('contact', 'ContactController');

Route::get('/import', 'ContactController@import');
Route::get('/burndown', 'ContactController@burndown');

