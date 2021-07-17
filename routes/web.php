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
Route::post('/pemilik-user', 'App\Http\Controllers\Controller@searchpemilikuser');
Route::get('/pemilik-rekomendasi', 'App\Http\Controllers\Controller@pemilikrekomendasi');
Route::get('/pemilik-pengadaan', 'App\Http\Controllers\Controller@pemilikpengadaan');
Route::post('/pemilik-pengadaan', 'App\Http\Controllers\Controller@searchpemilikpengadaan');
Route::get('/pemilik-penjualan', 'App\Http\Controllers\Controller@pemilikpenjualan');
Route::post('/pemilik-penjualan', 'App\Http\Controllers\Controller@searchpemilikpenjualan');
Route::get('/pemilik-kadaluarsa', 'App\Http\Controllers\Controller@pemilikkadaluarsa');
Route::get('/pemilik-hapusobat', 'App\Http\Controllers\Controller@pemilikhapusobat');
Route::get('/pemilik-riwayat', 'App\Http\Controllers\Controller@pemilikriwayat');
Route::post('/pemilik-riwayat', 'App\Http\Controllers\Controller@searchpemilikriwayat');
Route::get('/cetak-penjualan', 'App\Http\Controllers\Controller@cetakpemilikpenjualan');
Route::get('/cetak-pengadaan', 'App\Http\Controllers\Controller@cetakpemilikpengadaan');
Route::get('/cetak-riwayat', 'App\Http\Controllers\Controller@cetakpemilikriwayat');

//adminobat
Route::get('/obat-kategori', 'App\Http\Controllers\Controller@obatkategori');
Route::get('/obat-obat', 'App\Http\Controllers\Controller@obatobat');
Route::get('/obat-penjualan', 'App\Http\Controllers\Controller@obatpenjualan');
Route::post('/obat-obat', 'App\Http\Controllers\Controller@searchobatobat');
Route::post('/obat-penjualan', 'App\Http\Controllers\Controller@searchobatpenjualan');

//pengadaan
Route::get('/pengadaan-supplier', 'App\Http\Controllers\Controller@pengadaansupplier');
Route::get('/pengadaan-pengadaan', 'App\Http\Controllers\Controller@pengadaanpengadaan');
Route::post('/pengadaan-pengadaan', 'App\Http\Controllers\Controller@searchpengadaanpengadaan');
Route::get('/cetak-pengadaan-pengadaan', 'App\Http\Controllers\Controller@cetakpengadaanpengadaan');

//kasir
Route::get('/kasir-transaksi', 'App\Http\Controllers\Controller@kasirtransaksi');
Route::get('/kasir-riwayat', 'App\Http\Controllers\Controller@kasirriwayat');
Route::get('/kasir-transaksi-resep', 'App\Http\Controllers\Controller@kasirtransaksiresep');
Route::get('/kasir-transaksi-nonresep', 'App\Http\Controllers\Controller@kasirtransaksinonresep');
Route::post('/kasir-riwayat', 'App\Http\Controllers\Controller@searchkasirriwayat');

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
Route::post('/edit-laba', 'App\Http\Controllers\Controller@editlaba');
//CRUD Supplier
Route::post('/add-supplier', 'App\Http\Controllers\Controller@addsupplier');
Route::get('/delete-supplier{id}', 'App\Http\Controllers\Controller@delsupplier');
Route::post('/edit-supplier', 'App\Http\Controllers\Controller@editsupplier');
//CRUD Pengadaan
Route::post('/add-pengadaan', 'App\Http\Controllers\Controller@addpengadaan');
//CRUD OBAT KADALUARSA
Route::get('/delete-kadaluarsa{id}', 'App\Http\Controllers\Controller@delkadaluarsa');

//tambahan

Route::get('/x','App\Http\Controllers\Controller@index');
Route::get('/search','App\Http\Controllers\Controller@search');
Route::get('/add{id}', 'App\Http\Controllers\Controller@add');
Route::post('/add-cart', 'App\Http\Controllers\Controller@addcart');
Route::post('/add-transaksi', 'App\Http\Controllers\Controller@addtransaksi');
Route::get('/delete-cart{id}', 'App\Http\Controllers\Controller@delcart');
Route::post('/edit-cart', 'App\Http\Controllers\Controller@editcart');
Route::post('/edit-profil', 'App\Http\Controllers\Controller@editprofil');
Route::get('/kasir-nota{id}', 'App\Http\Controllers\Controller@kasirnota');
