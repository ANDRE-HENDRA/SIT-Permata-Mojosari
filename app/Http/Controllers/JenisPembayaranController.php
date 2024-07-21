<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Jenis Pembayaran";
	}

	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'Jenis Pembayaran';
		return view('pages.jenis',$data);
	}

	public function form(Request $request) {
		$data = $this->data;
		if (!empty($request->id)) {
			// if(!$data['tahunAjaran'] = TahunAjaran::find($request->id)){
			// 	return ['status'=>'fail','message'=>'Data tahun ajaran tidak ditemukan'];
			// }
		}
		$data['kelas'] = Kelas::has('tahun_ajaran')->with('tahun_ajaran')->get();
		$content = view('pages.pembayaran.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}
}
