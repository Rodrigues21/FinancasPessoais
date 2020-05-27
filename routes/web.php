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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);

Route::get('/me', 'UserController@index')->name('me')->middleware('auth');
Route::get('/me/edit', 'UserController@edit')->name('me.edit')->middleware('auth');
Route::put('/me/edit', 'UserController@update')->name('me.update')->middleware('auth');

Route::get('/me/edit/password', 'UserController@editPassword')->name('me.edit.password')->middleware('auth');
Route::patch('/me/edit/password', 'UserController@updatePassword')->name('me.update.password')->middleware('auth');

Route::get('/perfis', 'UserController@perfis')->name('perfis')->middleware('auth');
Route::post('perfis/block', 'UserController@manageblock')->name('perfis.block')->middleware('auth');
Route::post('perfis/promote', 'UserController@managepromote')->name('perfis.promote')->middleware('auth');

Route::get('/contas', 'ContaController@index')->name('contas')->middleware('auth');
Route::get('/contas/create', 'ContaController@create')->name('contas.create')->middleware('auth');
Route::post('/contas/create', 'ContaController@store')->name('contas.store')->middleware('auth');
Route::get('/contas/{conta}/edit', 'ContaController@edit')->name('contas.edit')->middleware('auth');
Route::post('/contas/{conta}/edit', 'ContaController@update')->name('contas.update')->middleware('auth');
Route::get('/contas/{conta}/delete', 'ContaController@delete')->name('contas.delete')->middleware('auth');
Route::get('/contas/{conta}/forcedelete', 'ContaController@forcedelete')->name('contas.forcedelete')->middleware('auth');
Route::get('/contas/{conta}/activate', 'ContaController@activate')->name('contas.activate')->middleware('auth');

Route::get('/contas/detalhes/{conta}', 'MovimentoController@movimentosConta')->name('contas.detalhes')->middleware('auth');
Route::get('/contas/detalhes/{conta}/create', 'MovimentoController@create')->name('movimento.create')->middleware('auth');
Route::post('/contas/detalhes/{conta}/create', 'MovimentoController@store')->name('movimento.store')->middleware('auth');
Route::get('/movimentos/{movimento}/doc', 'MovimentoController@displayDoc')->name('movimentos.doc')->middleware('auth');
Route::delete('/movimentos/{movimento}', 'MovimentoController@destroy')->name('movimento.destroy')->middleware('auth');
Route::get('/movimentos/{movimento}/edit', 'MovimentoController@edit')->name('movimento.edit')->middleware('auth');
Route::post('/movimentos/{movimento}/edit', 'MovimentoController@update')->name('movimento.update')->middleware('auth');