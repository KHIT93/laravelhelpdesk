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

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('teams')->name('teams.')->group(function(){
    Route::get('/', 'HelpdeskTeamController@index')->name('index');
    Route::get('create', 'HelpdeskTeamController@create')->name('create');
    Route::post('create', 'HelpdeskTeamController@store')->name('store');
    Route::get('{team}', 'HelpdeskTeamController@show')->name('show');
    Route::get('{team}/edit', 'HelpdeskTeamController@edit')->name('edit');
    Route::post('{team}/edit', 'HelpdeskTeamController@update')->name('update');
    Route::delete('{team}/delete', 'HelpdeskTeamController@delete')->name('delete');
});

Route::prefix('tickets')->name('tickets.')->group(function(){
    Route::get('/', 'HelpdeskTicketController@index')->name('index');
    Route::get('all', 'HelpdeskTicketController@all')->name('all');
    Route::get('closed', 'HelpdeskTicketController@closed')->name('closed');
    Route::get('active', 'HelpdeskTicketController@active')->name('active');
    Route::get('create', 'HelpdeskTicketController@create')->name('create');
    Route::post('create', 'HelpdeskTicketController@store')->name('store');
    Route::get('{ticket}', 'HelpdeskTicketController@show')->name('show');
    Route::get('{ticket}/edit', 'HelpdeskTicketController@edit')->name('edit');
    Route::post('{ticket}/edit', 'HelpdeskTicketController@update')->name('update');
    Route::post('{ticket}/message', 'HelpdeskTicketController@message')->name('message');
    Route::get('{ticket}/attachments/{attachment}','HelpdeskTicketMessageAttachmentController@show')->name('attachment');
    Route::delete('{ticket}/delete', 'HelpdeskTicketController@delete')->name('delete');
});