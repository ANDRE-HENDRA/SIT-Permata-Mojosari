<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
			$table->string('kode');
			$table->string('nama_pembayaran');
			$table->string('jenis_pembayaran');
			$table->string('kelas');
			$table->string('tahun_ajaran');
			$table->foreignId('pembayaran_id');
			$table->foreignId('kelas_id');
			$table->foreignId('tahun_ajaran_id');
			$table->foreignId('jenis_pembayaran_id');
			$table->foreignId('siswa_id');
			$table->string('bulan')->nullable();
			$table->integer('nominal');
			$table->boolean('is_lunas');
			$table->date('tanggal_transaksi');
			$table->softDeletes();
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
        Schema::dropIfExists('transaksi');
    }
}
