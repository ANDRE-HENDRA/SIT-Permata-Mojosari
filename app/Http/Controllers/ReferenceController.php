<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
	public function getKelasByTahunAjaran(Request $request) {
		$tahunAjaranId = !empty($request->tahun_ajaran_id)?$request->tahun_ajaran_id:'';
		$data = Kelas::where('tahun_ajaran_id',$tahunAjaranId)->get();
		return ['status'=>'success','data'=>$data];
	}
}
