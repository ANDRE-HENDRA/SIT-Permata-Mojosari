<?php

namespace App\Http\Controllers;

use App\Models\DetailPembayaran;
use App\Models\JenisPembayaran;
use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\PembayaranKelas;
use Illuminate\Http\Request;
use DataTables, DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Data Pembayaran";
	}

	public function main(Request $request) {
		$data = $this->data;
		$data['menuActive'] = 'Data Pembayaran';
		if ($request->ajax()) {
			$data = Pembayaran::orderBy('nama','asc')
				->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('keterangan',function ($row) {
					return 'Sementara';
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
				->rawColumns(['actions','keterangan'])
				->toJson();
		}
		return view('pages.pembayaran.main',$data);
	}

	public function form(Request $request) {
		$data = $this->data;
		if (!empty($request->id)) {
			if(!$data['pembayaran'] = Pembayaran::with('pembayaran_kelas','detail_pembayaran')->find($request->id)){
				return ['status'=>'fail','message'=>'Data Pembayaran tidak ditemukan'];
			}
			$data['pembayaranKelas'] = implode(',',PembayaranKelas::where('pembayaran_id',$request->id)->get()->pluck('kelas_id')->toArray());
		}
		$data['jenisPembayaran'] = JenisPembayaran::get();
		$data['kelas'] = Kelas::with('tahun_ajaran')->has('tahun_ajaran')->get();
		$content = view('pages.pembayaran.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}

	public function store(Request $request) {
		DB::beginTransaction();
		try {
			$params = [
				'nama' => 'required',
				'nominal' => 'required',
				'jenis_pembayaran_id' => 'required_without:id',
				'jenis_kelamin' => 'required',
				'kelas' => 'required',
			];
			$messages = [
				'nama.required' => 'Nama Harus Diisi',
				'nominal.required' => 'Nominal Harus Diisi',
				'jenis_pembayaran_id.required_without' => 'Jenis Pembayaran Harus Diisi',
				'jenis_kelamin.required' => 'Jenis Kelamin Harus Diisi',
				'kelas.required' => 'Kelas Harus Diisi',
			];
	
			$validator = Validator::make($request->all(),$params,$messages);
			if ($validator->fails()) {
				foreach ($validator->errors()->toArray() as $key => $val) {
					$msg = $val[0]; # Get validation messages, only one
					break;
				}
				DB::rollBack();
				return ['status' => 'fail', 'message' => $msg];
			}
			if (!empty($request->id)) {
				if (!$pembayaran = Pembayaran::find($request->id)) {
					DB::rollBack();
					return ['status'=>'fail','message'=>'Data pembayaran tidak ditemukan'];
				}
			} else {
				if (!$jenisPembayaran = JenisPembayaran::find($request->jenis_pembayaran_id)) {
					DB::rollBack();
					return ['status'=>'fail','message'=>'Data jenis pembayaran tidak ditemukan'];
				}
				$pembayaran = new Pembayaran;
				$pembayaran->kode = $jenisPembayaran->kode;
				$pembayaran->jenis_pembayaran_id = $jenisPembayaran->id;
			}
			$pembayaran->nama = $request->nama;
			$pembayaran->nominal = abs((int) filter_var(str_replace(array('+','-'), '', $request->nominal), FILTER_SANITIZE_NUMBER_INT));
			$pembayaran->is_l = in_array($request->jenis_kelamin,['semua','L'])?'L':null;
			$pembayaran->is_p = in_array($request->jenis_kelamin,['semua','P'])?'P':null;
	
			$pembayaranKelas = PembayaranKelas::where('pembayaran_id',$pembayaran->id);
			$kelasLama = $pembayaranKelas->get()->pluck('kelas_id');
			$hapusKelas = PembayaranKelas::where('pembayaran_id',$pembayaran->id)->whereNotIn('kelas_id',$request->kelas)->delete();
			if (!$pembayaran->save()) {
				DB::rollBack();
				return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin! [errCode:02]'];
			}
			if (empty($request->id)) {
				$pembayaran->kode = $jenisPembayaran->kode.'.'.$pembayaran->id;
				if (!$pembayaran->save()) {
					DB::rollBack();
					return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin! [errCode:02]'];
				}
			}
			foreach ($request->kelas as $key => $value) {
				if (!in_array($value,$kelasLama->toArray())) {
					$newPembayaranKelas = new PembayaranKelas;
					$newPembayaranKelas->pembayaran_id = $pembayaran->id;
					$newPembayaranKelas->kelas_id = $value;
					if (!$newPembayaranKelas->save()) {
						DB::rollBack();
						return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin! [errCode:03]'];
					}
				}
			}
			if (isset($request->detail)) {
				foreach ($request->detail as $key => $v) {
					$value=(object)$v;
					if ($value->id) {
						$detailPembayaran = DetailPembayaran::find($value->id);
						if (!$detailPembayaran) {
							$detailPembayaran = new DetailPembayaran;
							$detailPembayaran->pembayaran_id = $pembayaran->id;
						}
					} else {
						$detailPembayaran = new DetailPembayaran;
						$detailPembayaran->pembayaran_id = $pembayaran->id;
					}
					$detailPembayaran->keterangan = $value->keterangan;
					$detailPembayaran->nominal = abs((int) filter_var(str_replace(array('+','-'), '', $value->nominal), FILTER_SANITIZE_NUMBER_INT));
					if (!$detailPembayaran->save()) {
						DB::rollBack();
						return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin! [errCode:04]'];
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
		if (!$pembayaran = Pembayaran::find($request->id)) {
			return ['status'=>'fail','message'=>'Data pembayaran tidak ditemukan'];
		}
		if (!$pembayaran->delete()) {
			return ['status'=>'error','message'=>'Gagal menghapus data, coba lagi atau hubungi admin!'];
		}
		// if (isset($request->permanent) && $request->permanent) {
		// }
		return ['status'=>'success','message'=>'Berhasil menghapus data!'];
	}
}
