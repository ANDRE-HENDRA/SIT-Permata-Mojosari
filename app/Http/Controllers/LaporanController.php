<?php

namespace App\Http\Controllers;

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
		return view('pages.laporan',$data);
	}
}
