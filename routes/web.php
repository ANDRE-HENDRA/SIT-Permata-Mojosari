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

Route::get('/', function () {
    return view('login', ["title" => "Login"]);
});

Route::get('/pages', function () {
    return view('pages.siswa');
});

Route::get('/kelas', function () {
    return view('pages.kelas');
});

Route::get('/tahun', function () {
    return view('pages.tahun');
});

Route::get('/jenis', function () {
    return view('pages.jenis');
});

Route::get('/pengaturan-akun', function () {
    return view('pages.setting_akun');
});

Route::get('/akun', function () {
    return view('pages.akun');
});
