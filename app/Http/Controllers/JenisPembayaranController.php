<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables, Help;

class JenisPembayaranController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Jenis Pembayaran";
	}

	public function main(Request $request) {
		$data = $this->data;
		$data['menuActive'] = 'Jenis Pembayaran';
		if ($request->ajax()) {
			$data = JenisPembayaran::orderBy('nama','asc')
				->get();
			return DataTables::of($data)
				->addIndexColumn()
				->editColumn('is_loop',function ($row) {
					if ($row->is_loop) {
						$bulan = [];
						foreach (explode(',',$row->loop_bulan) as $key => $value) {
							$bulan[] = Help::bulanIndo($value);
						}
						return 'Periode ('.implode(', ',$bulan).')';
					}
					return 'Sekali saat sekolah';
				})
				->editColumn('is_wajib',function ($row) {
					if ($row->is_wajib) {
						return '<span class="text-danger">Wajib</span>';
					}
					return 'Tidak Wajib';
				})
				->editColumn('is_kredit',function ($row) {
					if ($row->is_kredit) {
						return '<span class="text-success">Bisa Dicicil</span>';
					}
					return '<span class="text-danger">Tidak Bisa Dicicil</span>';
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
				->rawColumns(['actions','is_wajib','is_kredit'])
				->toJson();
		}
		return view('pages.jenis-pembayaran.main',$data);
	}

	public function form(Request $request) {
		$data = $this->data;
		if (!empty($request->id)) {
			if(!$data['jenisPembayaran'] = JenisPembayaran::find($request->id)){
				return ['status'=>'fail','message'=>'Data Jenis Pembayaran tidak ditemukan'];
			}
		}
		$content = view('pages.jenis-pembayaran.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}

	public function store(Request $request) {
		$params = [
			'nama' => 'required',
		];
		$messages = [
			'nama.required' => 'Nama Harus Diisi',
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
			if (!$jenisPembayaran = JenisPembayaran::find($request->id)) {
				return ['status'=>'fail','message'=>'Data jenis pembayaran tidak ditemukan'];
			}
		} else {
			$jenisPembayaran = new JenisPembayaran;
			$jenisPembayaran->kode = 'KD';
		}
		$jenisPembayaran->nama = $request->nama;
		$jenisPembayaran->is_loop = !empty($request->is_loop)?(boolean)$request->is_loop:false;
		$jenisPembayaran->is_wajib = !empty($request->is_wajib)?(boolean)$request->is_wajib:false;
		if ($jenisPembayaran->is_loop && empty($request->loop_bulan)) {
			return ['status'=>'fail','message'=>'Bulan wajib diisi'];
		} elseif ($jenisPembayaran->is_loop) {
			$jenisPembayaran->loop_bulan = implode(',',$request->loop_bulan);
		}
		$jenisPembayaran->is_kredit = !empty($request->is_kredit)?(boolean)$request->is_kredit:false;
		if (!$jenisPembayaran->save()) {
			return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin!'];
		}
		if (empty($request->id)) {
			$jenisPembayaran->kode = 'KD'.$jenisPembayaran->id;
			if (!$jenisPembayaran->save()) {
				return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin!'];
			}
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
		if (!$jenisPembayaran = JenisPembayaran::find($request->id)) {
			return ['status'=>'fail','message'=>'Data jenis pembayaran tidak ditemukan'];
		}
		if (!$jenisPembayaran->delete()) {
			return ['status'=>'error','message'=>'Gagal menghapus data, coba lagi atau hubungi admin!'];
		}
		// if (isset($request->permanent) && $request->permanent) {
		// }
		return ['status'=>'success','message'=>'Berhasil menghapus data!'];
	}
}
