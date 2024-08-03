<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
	use HasFactory;
	protected $table = 'siswa';

	public function transaksi() {
		return $this->hasMany(Transaksi::class,'siswa_id');
	}

	public function kelas_siswa() {
		return $this->hasMany(KelasSiswa::class,'siswa_id');
	}
}
