<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswaTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('siswa', function (Blueprint $table) {
			$table->id();
			$table->string('nama');
			$table->string('nis')->unique();
			$table->string('nisn')->nullable();
			$table->string('jenis_kelamin',1);
			$table->string('tahun_masuk');
			$table->string('tahun_keluar')->nullable();
			$table->string('telepon')->nullable();
			$table->string('tempat_lahir')->nullable();
			$table->date('tanggal_lahir')->nullable();
			$table->string('nama_ayah')->nullable();
			$table->string('nama_ibu')->nullable();
			$table->string('status')->nullable();
			$table->text('alamat')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('siswa');
	}
}
