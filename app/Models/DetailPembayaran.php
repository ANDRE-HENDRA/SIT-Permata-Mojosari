<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPembayaran extends Model
{
	use HasFactory;
	use SoftDeletes;
	public $table = 'detail_pembayaran';

	public function pembayaran() {
		return $this->belongsTo(Pembayaran::class,'pembayaran_id');
	}
}
