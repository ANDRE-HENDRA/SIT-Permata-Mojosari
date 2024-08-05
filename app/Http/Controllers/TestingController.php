<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestingController extends Controller
{
	public function migrate() {
		return 'Nothing to migrate';
		// Schema::create('siswa', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('nama');
		// 	$table->string('nis')->unique();
		// 	$table->string('nisn')->nullable();
		// 	$table->string('jenis_kelamin',1);
		// 	$table->string('tahun_masuk');
		// 	$table->string('tahun_keluar')->nullable();
		// 	$table->string('telepon')->nullable();
		// 	$table->string('tempat_lahir')->nullable();
		// 	$table->date('tanggal_lahir')->nullable();
		// 	$table->string('nama_ayah')->nullable();
		// 	$table->string('nama_ibu')->nullable();
		// 	$table->string('status')->nullable();
		// 	$table->text('alamat')->nullable();
		// 	$table->softDeletes();
		// 	$table->timestamps();
		// });
		// Schema::create('kelas', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('nama');
		// 	$table->integer('tahun_ajaran_id');
		// 	$table->softDeletes();
		// 	$table->timestamps();
		// });
		// Schema::create('tahun_ajaran', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('tahun_awal',4);
		// 	$table->string('tahun_akhir',4);
		// 	$table->softDeletes();
		// 	$table->timestamps();
		// });
		// Schema::create('jenis_pembayaran', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('nama');
		// 	$table->string('kode');
		// 	$table->boolean('is_loop');
		// 	$table->string('loop_bulan')->nullable();
		// 	$table->boolean('is_wajib');
		// 	$table->boolean('is_kredit');
		// 	$table->softDeletes();
		// 	$table->timestamps();
		// });
		// Schema::create('pembayaran', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('nama');
		// 	$table->string('kode');
		// 	$table->foreignId('jenis_pembayaran_id');
		// 	$table->integer('nominal');
		// 	$table->string('is_l',1)->nullable();
		// 	$table->string('is_p',1)->nullable();
		// 	$table->softDeletes();
		// 	$table->timestamps();
		// });
		// Schema::create('detail_pembayaran', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->foreignId('pembayaran_id');
		// 	$table->string('keterangan');
		// 	$table->integer('nominal');
		// 	$table->softDeletes();
		// 	$table->timestamps();
		// });
		// Schema::create('pembayaran_kelas', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->foreignId('pembayaran_id');
		// 	$table->foreignId('kelas_id');
		// 	$table->softDeletes();
		// 	$table->timestamps();
		// });
		// Schema::create('transaksi', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->string('kode');
		// 	$table->string('nama_pembayaran');
		// 	$table->string('jenis_pembayaran');
		// 	$table->string('kelas');
		// 	$table->string('tahun_ajaran');
		// 	$table->foreignId('pembayaran_id');
		// 	$table->foreignId('kelas_id');
		// 	$table->foreignId('tahun_ajaran_id');
		// 	$table->foreignId('jenis_pembayaran_id');
		// 	$table->foreignId('siswa_id');
		// 	$table->string('bulan')->nullable();
		// 	$table->integer('nominal');
		// 	$table->boolean('is_lunas');
		// 	$table->date('tanggal_transaksi');
		// 	$table->softDeletes();
		// 	$table->timestamps();
		// });
		// Schema::table('siswa', function (Blueprint $table) {
		// 	$table->string('nis')->change();
		// 	$table->string('tingkat');
		// });
		// Schema::table('kelas', function (Blueprint $table) {
		// 	$table->string('tingkat');
		// });
		// Schema::create('kelas_siswa', function (Blueprint $table) {
		// 	$table->id();
		// 	$table->foreignId('siswa_id');
		// 	$table->foreignId('kelas_id');
		// 	$table->timestamps();
		// });
		return 'done';
	}
}
