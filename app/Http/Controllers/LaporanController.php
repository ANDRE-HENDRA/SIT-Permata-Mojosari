<?php

namespace App\Http\Controllers;

use App\Models\JenisPembayaran;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use DataTables, Help;

class LaporanController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Laporan Keuangan";
	}

	public function main(Request $request) {
		if ($request->ajax()) {
			$tglAwal = date('Y-m-d',strtotime(explode(' - ',$request->jarakTanggal)[0]));
			$tglAkhir = date('Y-m-d',strtotime(explode(' - ',$request->jarakTanggal)[1]));
			$data = Transaksi::orderBy('id','asc')
				->with('siswa')
				->has('siswa')
				->has('pembayaran')
				->with(['pembayaran'=>function ($q) {
					$q->with('jenis_pembayaran')
					->has('jenis_pembayaran')
					->has('pembayaran_kelas')
					->with(['pembayaran_kelas' => function ($qq) {
						$qq->with(['kelas'=>function ($qqq) {
							$qqq->with('tahun_ajaran')->has('tahun_ajaran');
						}])->has('kelas');
					}]);
				}])
				// ->whereBetween('tanggal_transaksi',[$tglAwal,$tglAkhir])
				->where('tahun_ajaran_id',$request->tahun_ajaran_id)
				->when($request->jenis_pembayaran!='semua',function ($q) use ($request) {
					$q->where('jenis_pembayaran_id',$request->jenis_pembayaran);
				})
				->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('keterangan',function ($row) {
					return $row->is_lunas ? '<span class="badge badge-success">Lunas</span>' : '<span class="badge badge-danger">Belum Lunas</span>';
				})
				->addColumn('nama',function ($row) {
					return $row->siswa->nama;
				})
				->addColumn('nis',function ($row) {
					return $row->siswa->nis.'/'.$row->siswa->nisn;
				})
				->editColumn('nominal',function ($row) {
					return Help::currencyFormatDecimal($row->nominal);
				})
				->addColumn('jenis',function ($row) {
					return $row->pembayaran->jenis_pembayaran->nama;
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
		$data = $this->data;
		$data['menuActive'] = 'Laporan Keuangan';
		$data['tahunAjaran'] = TahunAjaran::get();
		$data['kelas'] = Kelas::get();
		$data['jenisPembayaran'] = JenisPembayaran::get();
		return view('pages.laporan',$data);
	}

	function import(Request $request) {
		$data['transaksi'] = Transaksi::orderBy('id','asc')
			->with('siswa')
			->has('siswa')
			->has('pembayaran')
			->with(['pembayaran'=>function ($q) {
				$q->with('jenis_pembayaran')
				->has('jenis_pembayaran')
				->has('pembayaran_kelas')
				->with(['pembayaran_kelas' => function ($qq) {
					$qq->with(['kelas'=>function ($qqq) {
						$qqq->with('tahun_ajaran')->has('tahun_ajaran');
					}])->has('kelas');
				}]);
			}])
			// ->whereBetween('tanggal_transaksi',[$tglAwal,$tglAkhir])
			->where('tahun_ajaran_id',$request->tahun_ajaran_id)
			->when($request->jenis_pembayaran!='semua',function ($q) use ($request) {
				$q->where('jenis_pembayaran_id',$request->jenis_pembayaran);
			})
			->get();
		$data['total'] = $data['transaksi']->sum('nominal');
		return view('pages.print-pdf-laporan',$data);
	}
}
