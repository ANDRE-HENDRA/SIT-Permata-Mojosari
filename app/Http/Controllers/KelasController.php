<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Validator, DataTables;

class KelasController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = 'Kelas';
	}

	public function main(Request $request) {
		$data = $this->data;
		$data['menuActive'] = 'Kelas';
		if ($request->ajax()) {
			$data = Kelas::orderBy('id','desc')
				->with('tahun_ajaran')
				->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('tahun_ajaran',function ($row) {
					return $row->tahun_ajaran?$row->tahun_ajaran->tahun_awal.'/'.$row->tahun_ajaran->tahun_akhir:'-';
				})
				->addColumn('actions',function ($row) {
					$tahunAjaran = $row->tahun_ajaran?$row->tahun_ajaran->tahun_awal.'/'.$row->tahun_ajaran->tahun_akhir:'-';
					$html = '';
					$html .= '<button type="button" class="btn btn-success btn-sm" onclick="edit('.$row->id.',this)">
									<i class="fa fa-pencil-alt" aria-hidden="true"></i>
									edit
								</button>';
					$html .= '<button type="button" class="btn btn-danger btn-sm ml-1" onclick="hapus('.$row->id.',this,`'.$row->nama.' ('.$tahunAjaran.')`)">
									<i class="fa fa-trash" aria-hidden="true"></i>
									hapus
								</button>';
					return $html;
				})
				->rawColumns(['actions'])
				->toJson();
		}
		return view('pages.master.kelas.main',$data);
	}

	public function form(Request $request) {
		$data = $this->data;
		if (!empty($request->id)) {
			if(!$data['kelas'] = Kelas::find($request->id)){
				return ['status'=>'fail','message'=>'Data kelas tidak ditemukan'];
			}
		}
		$data['tahunAjaran'] = TahunAjaran::get();
		$content = view('pages.master.kelas.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}

	public function store(Request $request) {
		$params = [
			'nama' => 'required',
			'tahun_ajaran_id' => 'required',
		];
		$messages = [
			'nama.required' => 'Nama Harus Diisi',
			'tahun_ajaran_id.required' => 'Tahun Ajaran Harus Diisi',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		if (!empty($request->id)) {
			if (!$kelas = Kelas::find($request->id)) {
				return ['status'=>'fail','message'=>'Data kelas tidak ditemukan'];
			}
		} else {
			$kelas = new Kelas;
		}
		$kelas->nama = $request->nama;
		$kelas->tahun_ajaran_id = $request->tahun_ajaran_id;
		if (!$kelas->save()) {
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
		if (!$kelas = Kelas::find($request->id)) {
			return ['status'=>'fail','message'=>'Data kelas tidak ditemukan'];
		}
		if (!$kelas->delete()) {
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
		if (!$kelas = Kelas::onlyTrashed()->find($request->id)) {
			return ['status'=>'fail','message'=>'Data kelas tidak ditemukan'];
		}
		if (!$kelas->restore()) {
			return ['status'=>'error','message'=>'Gagal merestore data, coba lagi atau hubungi admin!'];
		}
		return ['status'=>'success','message'=>'Berhasil merestore data!'];
	}
}
