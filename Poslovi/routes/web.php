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

Route::get('/', 'HomeController@index')->name('home');
Route::resource('jobs', 'JobController');
Route::get('/activate/job/{id}', 'JobController@activate')->name('activate.job');
Route::get('/status/job/{id}', 'JobController@spam')->name('job.spam');
