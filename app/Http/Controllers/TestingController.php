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
		return 'done';
	}
}
