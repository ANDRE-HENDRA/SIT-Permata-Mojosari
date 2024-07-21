<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Laporan Keuangan";
	}

	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'Laporan Keuangan';
		$data['tahunAjaran'] = TahunAjaran::get();
		$data['kelas'] = Kelas::get();
		$data['jenisPembayaran'] = [
			
		];
		return view('pages.laporan',$data);
	}
}
