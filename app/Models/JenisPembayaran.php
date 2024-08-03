<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisPembayaran extends Model
{
	use HasFactory;
	use SoftDeletes;
	public $table = 'jenis_pembayaran';

	public function pembayaran() {
		return $this->hasMany(Pembayaran::class,'jenis_pembayaran_id');
	}
}
