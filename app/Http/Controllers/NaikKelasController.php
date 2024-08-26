<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NaikKelasController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = 'Naik Kelas';
	}

	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'Naik Kelas';
		$data['tahunAjaran'] = TahunAjaran::get();
		return view('pages.master.naik-kelas.main',$data);
	}

	public function store(Request $request) {
		$params = [
			'kelas_id_asal' => 'required',
			'kelas_id_tujuan' => 'required',
			// 'siswa_id' => 'required',
		];
		$messages = [
			'kelas_id_asal.required' => 'Kelas Asal Harus Diisi',
			'kelas_id_tujuan.required' => 'Kelas Tujuan Harus Diisi',
			// 'siswa_id.required' => 'Nama Harus Diisi',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		DB::beginTransaction();
		try {
			if (!$kelasAsal = Kelas::find($request->kelas_id_asal)) {
				DB::rollBack();
				return ['status' => 'fail', 'message' => 'Data kelas asal yang dipilih tidak tersedia'];
			}
			if (!$kelasTujuan = Kelas::find($request->kelas_id_tujuan)) {
				DB::rollBack();
				return ['status' => 'fail', 'message' => 'Data kelas tujuan yang dipilih tidak tersedia'];
			}
			$kelasSiswaAsal = KelasSiswa::where('kelas_id',$kelasAsal->id)->get();
			$total = 0;
			foreach ($kelasSiswaAsal as $k => $v) {
				if ($cekSiswa = KelasSiswa::whereHas('kelas',function ($q) use ($kelasTujuan) {
						$q->where('tahun_ajaran_id',$kelasTujuan->tahun_ajaran_id)
						->where('id','!=',$kelasTujuan->id);
					})
					->with('siswa')
					->where('siswa_id',$v->siswa_id)
					->first()) {
					DB::rollBack();
					return ['status'=>'fail','message'=>'Gagal menyimpan data, siswa dengan nama '.$cekSiswa->siswa->nama.' sudah ada di kelas lain di tahun ajaran yang sama'];
				}
				if (!$kelasSiswa = KelasSiswa::where(['kelas_id'=>$kelasTujuan->id,'siswa_id'=>$v->siswa_id])->first()) {
					$newKelasSiswa = new KelasSiswa;
					$newKelasSiswa->kelas_id = $kelasTujuan->id;
					$newKelasSiswa->siswa_id = $v->siswa_id;
					if (!$newKelasSiswa->save()) {
						DB::rollBack();
						return ['status'=>'fail','message'=>'Gagal menyimpan data'];
					}
					$total+=1;
				}
			}
			DB::commit();
			return ['status'=>'success','message'=>"Berhasil menambahkan $total siswa ke kelas tujuan!"];
		} catch (\Throwable $th) {
			Log::info($th->getMessage());
			DB::rollBack();
			throw $th;
			return ['status'=>'error','message'=>'Terjadi Kesalahan Sistem!'];
		}
	}

	public function getSiswa(Request $request) {
		$kelas = Kelas::find($request->kelas_id);
		if (!$kelas) {
			return ['status' => 'fail', 'message' => 'Data kelas yang dipilih tidak tersedia'];
		}
		$data['siswa'] = KelasSiswa::where('kelas_id',$kelas->id)->with('siswa')->has('siswa')->get();
		$data['count'] = $data['siswa']->count();
		return ['status' => 'success', 'data' => $data];
	}
}
