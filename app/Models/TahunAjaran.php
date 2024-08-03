<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAjaran extends Model
{
    use SoftDeletes;
    use HasFactory;
	protected $table = 'tahun_ajaran';

    public function kelas() {
        return $this->hasMany(Kelas::class,'tahun_ajaran_id');
    }
}
