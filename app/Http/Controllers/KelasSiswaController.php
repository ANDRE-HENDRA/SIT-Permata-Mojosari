<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use DataTables, DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KelasSiswaController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = 'Kelas Siswa';
	}

	
	public function main(Request $request) {
		$data = $this->data;
		$data['menuActive'] = 'Kelas Siswa';
		if ($request->ajax()) {
			$data = Kelas::orderBy('id','desc')
				->with('tahun_ajaran')
				->with('kelas_siswa')
				->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('tahun_ajaran',function ($row) {
					return $row->tahun_ajaran?$row->tahun_ajaran->tahun_awal.'/'.$row->tahun_ajaran->tahun_akhir:'-';
				})
				->addColumn('siswa',function ($row) {
					return count($row->kelas_siswa);
				})
				->addColumn('actions',function ($row) {
					$tahunAjaran = $row->tahun_ajaran?$row->tahun_ajaran->tahun_awal.'/'.$row->tahun_ajaran->tahun_akhir:'-';
					$html = '';
					$html .= '<button type="button" class="btn btn-success btn-sm" onclick="edit('.$row->id.',this)">
									<i class="fa fa-pencil-alt" aria-hidden="true"></i>
									edit
								</button>';
					return $html;
				})
				->rawColumns(['actions'])
				->toJson();
		}
		return view('pages.master.kelas-siswa.main',$data);
	}

	public function form(Request $request) {
		$data = $this->data;
		if (!empty($request->id)) {
			if(!$data['kelas'] = Kelas::with(['kelas_siswa'=>function ($q) {
				$q->with('siswa')->has('siswa');
			}])->find($request->id)){
				return ['status'=>'fail','message'=>'Data kelas siswa tidak ditemukan'];
			}
		}
		$content = view('pages.master.kelas-siswa.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}

	public function store(Request $request) {
		$params = [
			'kelas_id' => 'required',
			// 'siswa_id' => 'required',
		];
		$messages = [
			'kelas_id.required' => 'Kelas Harus Diisi',
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
			if (!$kelas = Kelas::find($request->kelas_id)) {
				DB::rollBack();
				return ['status'=>'fail','message'=>'Data kelas tidak ditemukan'];
			}
			if (isset($request->siswa_id)) {
				foreach ($request->siswa_id as $key => $value) {
					if ($cekSiswa = KelasSiswa::whereHas('kelas',function ($q) use ($kelas) {
						$q->where('tahun_ajaran_id',$kelas->tahun_ajaran_id)
						->where('id','!=',$kelas->id);
					})
					->with('siswa')
					->where('siswa_id',$value)
					->first()) {
						DB::rollBack();
						return ['status'=>'fail','message'=>'Gagal menyimpan data, siswa dengan nama '.$cekSiswa->siswa->nama.' sudah ada di kelas lain di tahun ajaran yang sama'];
					}
				}
			}
			$siswaId = $request->siswa_id?$request->siswa_id:[];
			$deleteKelasSiswa = KelasSiswa::where('kelas_id',$kelas->id)
				->whereNotIn('siswa_id',$siswaId)
				->delete();
			if (isset($request->siswa_id)) {
				foreach ($request->siswa_id as $key => $value) {
					if (!$kelasSiswa = KelasSiswa::where(['kelas_id'=>$kelas->id,'siswa_id'=>$value])->first()) {
						$newKelasSiswa = new KelasSiswa;
						$newKelasSiswa->kelas_id = $kelas->id;
						$newKelasSiswa->siswa_id = $value;
						if (!$newKelasSiswa->save()) {
							DB::rollBack();
							return ['status'=>'fail','message'=>'Gagal menyimpan data'];
						}
					}
				}
			}
			DB::commit();
			return ['status'=>'success','message'=>'Berhasil menyimpan data!'];
		} catch (\Throwable $th) {
			Log::info($th->getMessage());
			DB::rollBack();
			throw $th;
			return ['status'=>'error','message'=>'Terjadi Kesalahan Sistem!'];
		}
	}

	public function cariSiswa(Request $request) {
		$text_search = $request->q ?? '';
		$data =  Siswa::select('id', 'nama')->selectRaw("concat(nis, '/', coalesce(nisn,'-')) as nis_nisn")->where('nis', 'like', "%$text_search%")->orWhere('nama',  'like', "%$text_search%")
		->get();
		return response()->json($data, 200);
	}

	public function getSiswa(Request $request) {
		$data =  Siswa::select('id', 'nama')->selectRaw("concat(nis, '/', coalesce(nisn,'-')) as nis_nisn")->find($request->id);
		if ($data) {
			return ['status'=>'success','data'=>$data];
		}
		return ['status'=>'fail','message'=>'Siswa tidak ditemukan'];
	}
}
