<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
	use HasFactory;
	use SoftDeletes;
	protected $table = 'kelas';

	public function tahun_ajaran() {
		return $this->belongsTo(TahunAjaran::class,'tahun_ajaran_id');
	}

	public function pembayaran_kelas() {
		return $this->hasMany(PembayaranKelas::class, 'kelas_id');
	}

	public function kelas_siswa() {
		return $this->hasMany(KelasSiswa::class, 'kelas_id');
	}
}
