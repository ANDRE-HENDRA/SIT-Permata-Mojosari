<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Validator, DataTables;

class TahunAjaranController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = 'Tahun Ajaran';
	}

	public function main(Request $request) {
		$data = $this->data;
		if ($request->ajax()) {
			$data = TahunAjaran::orderBy('tahun_awal','desc')->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('tahun_ajaran',function ($row) {
					return $row->tahun_awal.'/'.$row->tahun_akhir;
				})
				->addColumn('actions',function ($row) {
					$html = '';
					$html .= '<button type="button" class="btn btn-success btn-sm" onclick="edit('.$row->id.',this)">
									<i class="fa fa-pencil-alt" aria-hidden="true"></i>
									edit
								</button>';
					$html .= '<button type="button" class="btn btn-danger btn-sm ml-1" onclick="hapus('.$row->id.',this)">
									<i class="fa fa-trash" aria-hidden="true"></i>
									hapus
								</button>';
					return $html;
				})
				->rawColumns(['actions'])
				->toJson();
		}
		return view('pages.master.tahun-ajaran.main',$data);
	}

	public function form(Request $request) {
		$data = $this->data;
		if (!empty($request->id)) {
			if(!$data['tahunAjaran'] = TahunAjaran::find($request->id)){
				return ['status'=>'fail','message'=>'Data tahun ajaran tidak ditemukan'];
			}
		}
		$content = view('pages.master.tahun-ajaran.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}

	public function store(Request $request) {
		$params = [
			'tahun_awal' => 'required',
			'tahun_akhir' => 'required',
		];
		$messages = [
			'tahun_awal.required' => 'Tahun Awal Harus Diisi',
			'tahun_akhir.required' => 'Tahun Akhir Harus Diisi',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		$tahunAjaran = TahunAjaran::where([
				'tahun_awal'=>$request->tahun_awal,
				'tahun_akhir'=>$request->tahun_akhir
			])->
			when(!empty($request->id),function ($q) use ($request) {
				$q->where('id','!=',$request->id);
			})->
			withTrashed()->
			first();
		if ($tahunAjaran && $tahunAjaran->deleted_at) {
			return [
				'status'=>'restore',
				'message'=>"Sistem menemukan data tahun ajaran $request->tahun_awal / $request->tahun_akhir yang terhapus pada $tahunAjaran->deleted_at",
				'restore_id'=>$tahunAjaran->id
			];
		} elseif ($tahunAjaran) {
			return [
				'status'=>'fail',
				'message'=>"Sistem menemukan data tahun ajaran $request->tahun_awal / $request->tahun_akhir yang sudah tersimpan"
			];
		}
		if (!empty($request->id)) {
			if (!$tahunAjaran = TahunAjaran::find($request->id)) {
				return ['status'=>'fail','message'=>'Data tahun ajaran tidak ditemukan'];
			}
		} else {
			$tahunAjaran = new TahunAjaran;
		}
		$tahunAjaran->tahun_awal = $request->tahun_awal;
		$tahunAjaran->tahun_akhir = $request->tahun_akhir;
		if (!$tahunAjaran->save()) {
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
		if (!$tahunAjaran = TahunAjaran::find($request->id)) {
			return ['status'=>'fail','message'=>'Data tahun ajaran tidak ditemukan'];
		}
		if (!$tahunAjaran->delete()) {
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
		if (!$tahunAjaran = TahunAjaran::onlyTrashed()->find($request->id)) {
			return ['status'=>'fail','message'=>'Data tahun ajaran tidak ditemukan'];
		}
		if (!$tahunAjaran->restore()) {
			return ['status'=>'error','message'=>'Gagal merestore data, coba lagi atau hubungi admin!'];
		}
		return ['status'=>'success','message'=>'Berhasil merestore data!'];
	}
}
