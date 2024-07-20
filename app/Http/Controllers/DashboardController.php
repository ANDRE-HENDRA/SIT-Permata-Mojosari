<?php

namespace App\Http\Controllers;

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
		$data['menuActive'] = 'Dashboard';
		$data['tahunAjaran'] = TahunAjaran::get();
		return view('pages.dashboard',$data);
	}
}
