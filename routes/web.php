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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/clients', 'HomeController@clients')->name('clients');

Route::any('/admin/trainerlist', 'HomeController@trainerlist')->name('trainerlist');

Route::any('/admin/edittrainer/{id}', 'HomeController@edittrainer')->name('edittrainer');

Route::any('/admin/edittrainermodels/{id}', 'HomeController@edittrainermodels')->name('edittrainermodels');

Route::any('/admin/addtrainer', 'HomeController@addtrainer')->name('addtrainer');

Route::any('/admin/timetable/{id}', 'HomeController@timetable')->name('timetable');

Route::any('/admin/shiftreport/{date?}', 'HomeController@shiftreport1')->name('shiftreport1');

Route::any('/admin/shiftdetails/{id}', 'HomeController@shiftdetails')->name('shiftdetails');

Route::any('/admin/ajaxAdminData', 'HomeController@ajaxAdminData');

//Route::any('/admin/genpassword', 'HomeController@genpassword');

Route::any('/admin/schedule', 'HomeController@schedule');
