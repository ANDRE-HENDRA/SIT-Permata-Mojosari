<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Dashboard";
	}

	public function main() {
		$data = $this->data;
		$data['kb'] = Siswa::where('tingkat','kb')->count();
		$data['tk'] = Siswa::where('tingkat','tk')->count();
		$data['sd'] = Siswa::where('tingkat','sd')->count();
		$data['semua'] = Siswa::where('tingkat','!=',null)->count();
		$data['menuActive'] = 'Dashboard';
		$data['tahunAjaran'] = TahunAjaran::get();
		return view('pages.dashboard',$data);
	}
}
