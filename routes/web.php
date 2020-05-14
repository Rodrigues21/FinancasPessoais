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