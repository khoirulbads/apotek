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
//general
Route::get('/', function () {
    return redirect('/auth');
});
Route::get('/auth', 'App\Http\Controllers\Controller@login');
Route::post('/actionLogin', 'App\Http\Controllers\Controller@actionLogin');
Route::get('/logout', 'App\Http\Controllers\Controller@logout');
Route::get('/dashboard', 'App\Http\Controllers\Controller@dashboard');
//pemilik
Route::get('/pemilik-user', 'App\Http\Controllers\Controller@pemilikuser');

//adminobat
Route::get('/obat-kategori', 'App\Http\Controllers\Controller@obatkategori');
Route::get('/obat-obat', 'App\Http\Controllers\Controller@obatobat');

//CRUD User
Route::post('/add-user', 'App\Http\Controllers\Controller@adduser');
Route::get('/delete-user{id}', 'App\Http\Controllers\Controller@deluser');
Route::post('/edit-user', 'App\Http\Controllers\Controller@edituser');
//CRUD kategori
Route::post('/add-kategori', 'App\Http\Controllers\Controller@addkategori');
Route::get('/delete-kategori{id}', 'App\Http\Controllers\Controller@delkategori');
Route::post('/edit-kategori', 'App\Http\Controllers\Controller@editkategori');
//CRUD obat
Route::post('/add-obat', 'App\Http\Controllers\Controller@addobat');
Route::get('/delete-obat{id}', 'App\Http\Controllers\Controller@delobat');
Route::post('/edit-obat', 'App\Http\Controllers\Controller@editobat');

