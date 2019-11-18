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

// homepage route
Route::get('/', 'TicketsController@index')->name('tickets.index');

// ticket routes
Route::get('/tickets', 'TicketsController@index')->name('tickets.index');
Route::get('/tickets/create', 'TicketsController@create')->name('tickets.create');
Route::post('/tickets', 'TicketsController@store')->name('tickets.store');
Route::get('/tickets/{ticket}', 'TicketsController@show')->name('tickets.show');
Route::get('/tickets/{ticket}/edit', 'TicketsController@edit')->name('tickets.edit');
Route::patch('/tickets/{ticket}', 'TicketsController@update')->name('tickets.update');
Route::delete('/tickets/{ticket}', 'TicketsController@destroy')->name('tickets.destroy');
