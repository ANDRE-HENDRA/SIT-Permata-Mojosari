<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
	use HasFactory;
	use SoftDeletes;
	public $table = 'pembayaran';

	public function pembayaran_kelas() {
		return $this->hasMany(PembayaranKelas::class,'pembayaran_id');
	}

	public function detail_pembayaran() {
		return $this->hasMany(DetailPembayaran::class,'pembayaran_id');
	}

	public function jenis_pembayaran() {
		return $this->belongsTo(JenisPembayaran::class,'jenis_pembayaran_id');
	}

	public function transaksi() {
		return $this->hasMany(JenisPembayaran::class,'pembayaran_id');
	}

	public function kelas() {
		return $this->hasMany(Kelas::class,'pembayaran_id');
	}
}
