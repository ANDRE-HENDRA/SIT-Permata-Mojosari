<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Pembayaran;
use App\Models\PembayaranKelas;
use App\Models\Siswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB, Help;
use Illuminate\Support\Facades\Log;

class BayarController extends Controller
{
	protected $data;
	
	public function __construct() {
		$this->data['title'] = "Pembayaran";
	}
	
	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'Pembayaran';
		return view('pages.bayar.main',$data);
	}
	
	public function jenisPembayaran(Request $request) {
		$kelasSiswa = KelasSiswa::with('kelas')->has('kelas')->where('siswa_id',$request->siswa_id)->get()->pluck('kelas_id');
		$data['jenisPembayaran'] = JenisPembayaran::with(['pembayaran'=>function ($q) {
				$q->with(['pembayaran_kelas'=>function ($qq) {
					$qq->with(['kelas'=>function ($qqq) {
						$qqq->with('tahun_ajaran');
					}]);
				}]);
			}])
			->whereHas('pembayaran',function ($q) use ($kelasSiswa) {
				$q->whereHas('pembayaran_kelas',function ($qq) use ($kelasSiswa) {
					$qq->whereHas('kelas',function ($qqq) {
						$qqq->has('tahun_ajaran');
					})->whereIn('kelas_id',$kelasSiswa);
				});
			})->get();
		$content = view('pages.bayar.jenis-pembayaran-list',$data)->render();
		return ['status'=>'success','response'=>$content];
	}
	
	public function tagihanSiswa(Request $request) {
		$kelasSiswa = KelasSiswa::with('kelas')->has('kelas')->where('siswa_id',$request->siswa_id)->get()->pluck('kelas_id');
		$data['pembayaran'] = Pembayaran::with('jenis_pembayaran')
		->whereHas('jenis_pembayaran',function ($q) use ($request) {
			$q->where('id',$request->jenis_id);
		})
		->whereHas('pembayaran_kelas',function ($qq) use ($kelasSiswa) {
			$qq->whereHas('kelas',function ($qqq) {
				$qqq->has('tahun_ajaran');
			})->whereIn('kelas_id',$kelasSiswa);
		})
		->with(['pembayaran_kelas'=>function ($qq) {
			$qq->with(['kelas'=>function ($qqq) {
				$qqq->with('tahun_ajaran');
			}]);
		}])
		->first();
		// $data['pembayaran'] = Pembayaran::with('jenis_pembayaran')
		// ->whereHas('jenis_pembayaran',function ($q) use ($request) {
		// 	$q->where('id',$request->jenis_id);
		// })
		// ->get();
		$content = view('pages.bayar.tagihan-list',$data)->render();
		return ['status'=>'success','response'=>$content];
	}
	
	public function form(Request $request) {
		$data = $this->data;
		// if (!empty($request->id)) {
		// 	$data['bayar'] = Transaksi::has('pembayaran')
		// 	->where('id',$request->id)
		// 	->first();
		// 	if(!$data['bayar']){
		// 		return ['status'=>'fail','message'=>'Data Transaksi tidak ditemukan'];
		// 	}
		// }
		if (!$data['siswa'] = Siswa::find($request->siswa_id)) {
			return ['status'=>'fail','message'=>'Data Siswa tidak ditemukan'];
		}
		// $data['kelas_siswa'] = KelasSiswa::with('kelas')->has('kelas')->where('siswa_id',$request->siswa_id)->get();
		// $kelasSiswa = $data['kelas_siswa']->pluck('kelas_id');
		$data['pembayaran_kelas'] = PembayaranKelas::
			with(['kelas'=>function ($q) {
				$q->with('tahun_ajaran')->has('tahun_ajaran');
			}])
			->with(['pembayaran'=>function ($q) {
				$q->with('jenis_pembayaran');
			}])
			->whereHas('pembayaran',function ($q) {
				$q->has('jenis_pembayaran');
			})
			->has('kelas')->find($request->id);
		// $data['pembayaran'] = Pembayaran::with('jenis_pembayaran')
		// 	->has('jenis_pembayaran')
		// 	->whereHas('pembayaran_kelas',function ($q) use ($request) {
		// 		$q->where('kelas_id',$request->id);
		// 	})
		// 	->with(['pembayaran_kelas' => function ($qq) use ($kelasSiswa) {
		// 		$qq->with(['kelas'=>function ($qqq) {
		// 			$qqq->with('tahun_ajaran')->has('tahun_ajaran');
		// 		}]);
		// 	}])
		// 	->where('id',$request->id_pembayaran)
		// 	->first();
		if (!$data['pembayaran_kelas']) {
			return ['status'=>'fail','message'=>'Siswa tidak memiliki tagihan di pembayaran tersebut'];
		}
		$data['bulan'] = [];
		foreach (explode(',',$data['pembayaran_kelas']->pembayaran->jenis_pembayaran->loop_bulan) as $key => $value) {
			if (Help::bulanIndo($value)) {
				$data['bulan'][] = (object)['m'=>$value,'bulan'=>Help::bulanIndo($value)];
			}
		}
		$data['transaksi'] = Transaksi::where(['pembayaran_id'=>$data['pembayaran_kelas']->pembayaran_id,'siswa_id'=>$request->siswa_id])->get();
		$content = view('pages.bayar.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}
	
	public function cari_siswa(Request $request) {
		$text_search = $request->q ?? '';
		$data =  Siswa::where('nis', 'like', "%$text_search%")->orWhere('nama',  'like', "%$text_search%")
		->get();
		return response()->json($data, 200);
	}

	public function getSiswa(Request $request) {
		$curTahunAjaran = in_array(date('m'),[1,2,3,4,5,6])?date('Y',strtotime(' +1 year')):date('Y');
		$siswa = Siswa::with(['kelas_siswa'=>function ($q) use ($curTahunAjaran){
			$q->with('kelas')->whereHas('kelas',function ($qq) use ($curTahunAjaran) {
				$qq->whereHas('tahun_ajaran',function ($qqq) use ($curTahunAjaran) {
					$qqq->where('tahun_awal',$curTahunAjaran);
				});
			});
		}])->find($request->siswa_id);
		return ['status'=>'success','data'=>$siswa];
	}

	public function store(Request $request) {
		$params = [
			'id_pembayaran' => 'required',
			'siswa_id' => 'required',
			'kelas_id' => 'required',
			'nominal' => 'required',
			'tanggal_transaksi' => 'required',
		];
		$messages = [
			'id_pembayaran.required' => 'Pembayaran Harus Diisi',
			'siswa_id.required' => 'Nama Harus Diisi',
			'kelas_id.required' => 'Kelas Harus Diisi',
			'tanggal_transaksi.required' => 'Tanggal Transaksi Harus Diisi',
			'nominal.required' => 'Nominal Transaksi Harus Diisi',
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
			if (!$pembayaran = Pembayaran::with('jenis_pembayaran')->has('jenis_pembayaran')->find($request->id_pembayaran)) {
				DB::rollBack();
				return ['status'=>'fail','message'=>'Data pembayaran tidak ditemukan'];
			}
			if (!$kelas = Kelas::with('tahun_ajaran')->has('tahun_ajaran')->find($request->kelas_id)) {
				DB::rollBack();
				return ['status'=>'fail','message'=>'Kelas yang dipilih tidak terdaftar dalam sistem'];
			}
			if ($transaksi = Transaksi::
					where(['pembayaran_id'=>$request->id_pembayaran,'siswa_id'=>$request->siswa_id])->
					when($pembayaran->jenis_pembayaran->is_kredit,function ($q) {
						$q->where('is_lunas',true);
					})->
					when(!$pembayaran->jenis_pembayaran->is_kredit,function ($q) use ($request) {
						$q->where('bulan',$request->bulan);
					})
					->first()) {
				DB::rollBack();
				return ['status'=>'fail','message'=>'Siswa telah melunasi tagihan ini!'];
			}
			$transaksi = new Transaksi;
			$transaksi->pembayaran_id = $pembayaran->id;
			$transaksi->nama_pembayaran = $pembayaran->nama;
			$transaksi->siswa_id = $request->siswa_id;
			$transaksi->kelas_id = $request->kelas_id;
			$transaksi->kelas = $kelas->nama;
			$transaksi->tahun_ajaran_id = $kelas->tahun_ajaran->id;
			$transaksi->tahun_ajaran = $kelas->tahun_ajaran->tahun_awal.'/'.$kelas->tahun_ajaran->tahun_akhir;
			$transaksi->jenis_pembayaran_id = $pembayaran->jenis_pembayaran->id;
			$transaksi->jenis_pembayaran = $pembayaran->jenis_pembayaran->nama;
			$transaksi->bulan = $request->bulan;
			$transaksi->nominal = abs((int) filter_var(str_replace(array('+','-'), '', $request->nominal), FILTER_SANITIZE_NUMBER_INT));
			$transaksi->is_lunas = true;
			$transaksi->tanggal_transaksi = date('Y-m-d',strtotime($request->tanggal_transaksi));
			$transaksi->kode = '-';
			if (!$transaksi->save()) {
				DB::rollBack();
				return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin! [errCode:02]'];
			}
			$transaksi->kode = $pembayaran->kode.'.'.$transaksi->id;
			if (!$transaksi->save()) {
				DB::rollBack();
				return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin! [errCode:02]'];
			}
			DB::commit();
			return ['status'=>'success','message'=>'Berhasil menyimpan data!','data'=>$transaksi];
		} catch (\Throwable $th) {
			Log::info($th->getMessage());
			DB::rollBack();
			throw $th;
			return ['status'=>'error','message'=>'Terjadi Kesalahan Sistem!'];
		}
	}

	public function invoice($id=1) {
		$data['transaksi'] = Transaksi::with(['pembayaran'=>function ($q) {
				$q->withTrashed()
				->with('kelas');
			}])
			->with('siswa')
			->find($id);
		return view('pages.bayar.invoice',$data);
	}

	public function getTagihan(Request $request) {
		$data['pembayaran'] = Pembayaran::has('jenis_pembayaran')->with('jenis_pembayaran')->find($request->id_pembayaran);
		$data['transaksi'] = Transaksi::where(['pembayaran_id'=>$request->id_pembayaran,'siswa_id'=>$request->siswa_id])->get();
		if (count($data['transaksi'])) {
			if ($data['pembayaran']->jenis_pembayaran->is_kredit) {
				$data['is_lunas'] = Transaksi::where(['pembayaran_id'=>$request->id_pembayaran,'siswa_id'=>$request->siswa_id,'is_lunas'=>true])->first()?true:false;
				$data['sisa'] = $data['pembayaran']->nominal - $data['transaksi']->sum('nominal');
				$data['terbayar'] = $data['transaksi']->sum('nominal');
			} else {
				$data['is_lunas'] = Transaksi::where(['pembayaran_id'=>$request->id_pembayaran,'siswa_id'=>$request->siswa_id,'bulan'=>$request->bulan])->first()?true:false;
				$data['sisa'] = $data['is_lunas']?0:$data['pembayaran']->nominal;
				$data['terbayar'] = $data['is_lunas']?$data['pembayaran']->nominal:0;
			}
			
		} else {
			$data['sisa'] = $data['pembayaran']->nominal;
			$data['terbayar'] = 0;
			$data['is_lunas'] = false;
		}
		return ['status'=>'success','data'=>$data];
	}
}
