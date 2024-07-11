<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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
	return redirect('dashboard');
});

Route::controller(LoginController::class)
->as('auth.')
->group(function () {
	Route::get('login','main')->name('login');
	Route::post('do-login','login')->name('doLogin');
	Route::get('logout','logout')->name('logout');
});

Route::middleware('auth')
->group(function () {
	Route::controller(DashboardController::class)
	->prefix('dashboard')
	->as('dashboard.')
	->group(function ($q) {
		Route::get('/','main')->name('main');
	});
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

Route::get('/data', function () {
	return view('pages.data');
});

Route::get('/bayar', function () {
	return view('pages.bayar');
});

Route::get('/pengaturan-akun', function () {
	return view('pages.setting_akun');
});

Route::get('/akun', function () {
	return view('pages.akun');
});

Route::get('/akun-user', function () {
	return view('pages.akunUser');
});

Route::get('/laporan', function () {
	return view('pages.laporan');
})->name('dashboard');
