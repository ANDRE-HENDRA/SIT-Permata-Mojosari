<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembayaranKelas extends Model
{
	use HasFactory;
	use SoftDeletes;
	public $table = 'pembayaran_kelas';

	public function pembayaran() {
		return $this->belongsTo(Pembayaran::class,'pembayaran_id');
	}

	public function kelas() {
		return $this->belongsTo(Kelas::class,'kelas_id');
	}
}
