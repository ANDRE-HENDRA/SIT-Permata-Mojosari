<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
	use HasFactory;
	use SoftDeletes;
	public $table = 'transaksi';

	public function siswa() {
		return $this->belongsTo(Siswa::class,'siswa_id');
	}

	public function pembayaran() {
		return $this->belongsTo(Pembayaran::class,'pembayaran_id');
	}
}
