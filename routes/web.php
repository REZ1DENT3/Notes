<?php

use Illuminate\Support\Facades\
{
    Auth, Route
};

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

Route::get('/', function ()
{
    return redirect(route('login', [], false));
});

Route::get('/note', function ()
{
    return redirect(route('note.index', [], false));
});

Auth::routes();

// note
Route::get('/notes', 'NoteController@index')->name('note.index');
Route::get('/note/create', 'NoteController@create')->name('note.create');
Route::get('/note/{node}', 'NoteController@show')->name('note.show')->where(['note' => '\d+']);
Route::get('/note/{node}/edit', 'NoteController@edit')->name('note.edit')->where(['note' => '\d+']);

Route::post('/note', 'NoteController@store')->name('note.store');
Route::post('/note/{note}', 'NoteController@show')->where(['note' => '\d+']);
Route::post('/note/{note}/edit', 'NoteController@edit')->where(['note' => '\d+']);
Route::post('/note/{note}/update', 'NoteController@update')->name('note.update')->where(['note' => '\d+']);

Route::delete('/note/{node}', 'NoteController@destroy')->name('note.destroy')->where(['note' => '\d+']);
