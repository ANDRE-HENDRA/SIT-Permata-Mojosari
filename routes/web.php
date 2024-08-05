<?php

use App\Http\Controllers\BayarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasSiswaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengaturanAkunController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UserController;
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
		Route::get('login', 'main')->name('login');
		Route::post('do-login', 'login')->name('doLogin');
		Route::get('logout', 'logout')->name('logout');
	});

Route::middleware('auth')
	->group(function () {
		Route::controller(DashboardController::class)
			->prefix('dashboard')
			->as('dashboard.')
			->group(function () {
				Route::get('/', 'main')->name('main');
			});

		Route::controller(SiswaController::class)
			->prefix('siswa')
			->as('siswa.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/form', 'form')->name('form');
				Route::post('/store', 'store')->name('store');
				Route::post('/delete','delete')->name('delete');
				Route::get('/import-form','importForm')->name('importForm');
				Route::post('/excel-to-array','excelToArray')->name('excelToArray');
			});

		Route::controller(TahunAjaranController::class)
			->prefix('tahun-ajaran')
			->as('tahunAjaran.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/form','form')->name('form');
				Route::post('/store','store')->name('store');
				Route::post('/delete','delete')->name('delete');
				Route::post('/restore','restore')->name('restore');
			});

		Route::controller(KelasController::class)
			->prefix('kelas')
			->as('kelas.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/form','form')->name('form');
				Route::post('/store','store')->name('store');
				Route::post('/delete','delete')->name('delete');
				Route::post('/restore','restore')->name('restore');
			});

			Route::controller(KelasSiswaController::class)
			->prefix('kelas-siswa')
			->as('kelasSiswa.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/form','form')->name('form');
				Route::post('/store','store')->name('store');
				Route::post('/cari-siswa','cariSiswa')->name('cariSiswa');
				Route::post('/get-siswa','getSiswa')->name('getSiswa');
			});

		Route::controller(PengaturanAkunController::class)
			->prefix('pengaturan-akun')
			->as('pengaturanAkun.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/store', 'store')->name('store');
				Route::post('/ubah-password', 'ubahPassword')->name('ubahPassword');
			});

		Route::controller(UserController::class)
			->prefix('user')
			->as('user.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/form', 'form')->name('form');
				Route::post('/store', 'store')->name('store');
				Route::post('/delete', 'delete')->name('delete');
				Route::post('/reset', 'reset')->name('reset');
			});

		Route::controller(JenisPembayaranController::class)
			->prefix('jenis-pembayaran')
			->as('jenisPembayaran.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/form', 'form')->name('form');
				Route::post('/store', 'store')->name('store');
				Route::post('/delete', 'delete')->name('delete');
			});

		Route::controller(PembayaranController::class)
			->prefix('pembayaran')
			->as('pembayaran.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/form', 'form')->name('form');
				Route::post('/store', 'store')->name('store');
				Route::post('/delete', 'delete')->name('delete');
			});

		Route::controller(BayarController::class)
			->prefix('bayar')
			->as('bayar.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::post('/jenis-pembayaran', 'jenisPembayaran')->name('jenisPembayaran');
				Route::post('/tagihan-siswa', 'tagihanSiswa')->name('tagihanSiswa');
				Route::post('/form', 'form')->name('form');
				Route::post('/store', 'store')->name('store');
				Route::post('/cari-siswa', 'cari_siswa')->name('cari_siswa');
				Route::post('/get-siswa', 'getSiswa')->name('getSiswa');
				Route::get('/invoice/{id?}', 'invoice')->name('invoice');
				Route::post('/get-tagihan', 'getTagihan')->name('getTagihan');
			});

		Route::controller(LaporanController::class)
			->prefix('laporan')
			->as('laporan.')
			->group(function () {
				Route::get('/', 'main')->name('main');
				Route::get('/import', 'import')->name('import');
			});

		Route::controller(ReferenceController::class)
			->prefix('reference')
			->as('reference.')
			->group(function () {
				Route::post('/get-kelas-by-tahun-ajaran', 'getKelasByTahunAjaran')->name('getKelasByTahunAjaran');
			});
	});

// Route::get('/pages', function () {
// 	return view('pages.siswa');
// });

// Route::get('/kelas', function () {
// 	return view('pages.kelas');
// });

// Route::get('/tahun', function () {
// 	return view('pages.tahun');
// });

// Route::get('/jenis', function () {
// 	return view('pages.jenis');
// });

// Route::get('/data', function () {
// 	return view('pages.data');
// });

// Route::get('/bayar', function () {
// 	return view('pages.bayar');
// });

// Route::get('/pengaturan-akun', function () {
// 	return view('pages.setting_akun');
// });

// Route::get('/akun', function () {
// 	return view('pages.akun');
// });

// Route::get('/akun-user', function () {
// 	return view('pages.akunUser');
// });

// Route::get('/laporan', function () {
// 	return view('pages.laporan');
// })->name('dashboard');

Route::controller(TestingController::class)
	->prefix('testing')
	->as('testing.')
	->group(function () {
		Route::get('/', function () {
			return 'Nothing';
		});

		Route::get('/migrate', 'migrate')->name('migrate');
	});
