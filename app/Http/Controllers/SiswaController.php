<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Help, Validator, DataTables;

class SiswaController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Siswa";
	}

	public function main(Request $request) {
		$data = $this->data;
		$data['menuActive'] = 'Siswa';
		if ($request->ajax()) {
			$data = Siswa::orderBy('nama','asc')
				->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('nis_nisn',function ($row) {
					return $row->nis.'/'.($row->nisn?$row->nisn:'-');
				})
				->editColumn('jenis_kelamin',function ($row) {
					if ($row->jenis_kelamin=='L') {
						return 'Laki-laki';
					} elseif ($row->jenis_kelamin=='P') {
						return 'Perempuan';
					} else {
						return '-';
					}
				})
				->addColumn('actions',function ($row) {
					$html = '';
					$html .= '<button type="button" class="btn btn-success btn-sm" onclick="edit('.$row->id.',this)">
									<i class="fa fa-pencil-alt" aria-hidden="true"></i>
									edit
								</button>';
					$html .= '<button type="button" class="btn btn-danger btn-sm ml-1" onclick="hapus('.$row->id.',this,`'.$row->nama.'`)">
									<i class="fa fa-trash" aria-hidden="true"></i>
									hapus
								</button>';
					return $html;
				})
				->rawColumns(['actions'])
				->toJson();
		}
		return view('pages.master.siswa.main',$data);
	}

	public function form(Request $request) {
		$data = $this->data;
		if (!empty($request->id)) {
			if(!$data['siswa'] = Siswa::find($request->id)){
				return ['status'=>'fail','message'=>'Data siswa tidak ditemukan'];
			}
		}
		$content = view('pages.master.siswa.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}

	public function store(Request $request) {
		$params = [
			'nis' => 'required',
			'nama' => 'required',
			'jenis_kelamin' => 'required',
			'tahun_masuk' => 'required',
		];
		$messages = [
			'nis.required' => 'NIS Harus Diisi',
			'nama.required' => 'Nama Harus Diisi',
			'jenis_kelamin.required' => 'Jenis Kelamin Harus Diisi',
			'tahun_masuk.required' => 'Tahun Masuk Harus Diisi',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		$siswa = Siswa::where([
				'nis'=>$request->nis
			])
			->when(!empty($request->id),function ($q) use ($request) {
				$q->where('id','!=',$request->id);
			})
			->first();
		if ($siswa) {
			return [
				'status'=>'fail',
				'message'=>"Sistem menemukan data siswa dengan NIS sama $request->nis"
			];
		}
		if (!empty($request->id)) {
			if (!$siswa = Siswa::find($request->id)) {
				return ['status'=>'fail','message'=>'Data siswa tidak ditemukan'];
			}
		} else {
			$siswa = new Siswa;
		}
		$siswa->nama = $request->nama;
		$siswa->nis = $request->nis;
		$siswa->nisn = $request->nisn;
		$siswa->jenis_kelamin = substr($request->jenis_kelamin,0,1);
		$siswa->tahun_masuk = $request->tahun_masuk;
		if (!$siswa->save()) {
			return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin!'];
		}
		return ['status'=>'success','message'=>'Berhasil menyimpan data!'];
	}

	public function delete(Request $request) {
		$params = [
			'id' => 'required',
		];
		$messages = [
			'id.required' => 'Data Tidak Valid',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		if (!$siswa = Siswa::find($request->id)) {
			return ['status'=>'fail','message'=>'Data siswa tidak ditemukan'];
		}
		if (!$siswa->delete()) {
			return ['status'=>'error','message'=>'Gagal menghapus data, coba lagi atau hubungi admin!'];
		}
		// if (isset($request->permanent) && $request->permanent) {
		// }
		return ['status'=>'success','message'=>'Berhasil menghapus data!'];
	}

	public function restore(Request $request) {
		$params = [
			'id' => 'required',
		];
		$messages = [
			'id.required' => 'Data Tidak Valid',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		if (!$siswa = Siswa::onlyTrashed()->find($request->id)) {
			return ['status'=>'fail','message'=>'Data siswa tidak ditemukan'];
		}
		if (!$siswa->restore()) {
			return ['status'=>'error','message'=>'Gagal merestore data, coba lagi atau hubungi admin!'];
		}
		return ['status'=>'success','message'=>'Berhasil merestore data!'];
	}
}
