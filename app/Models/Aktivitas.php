<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    use HasFactory;
	public $table = 'aktivitas';

    public function user() {
        return $this->belongsTo(Users::class,'user_id');
    }
}
