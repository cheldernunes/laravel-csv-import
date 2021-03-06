<?php


use Csvimport\Events\ImportFinished;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/upload', 'HomeController@upload')->name('upload');
Route::post('/savemap', 'HomeController@savemap')->name('savemap');


Route::get('/send',function(){;
    event(new ImportFinished());
    return "Event has been sent!";

});