<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembayaranController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Data Pembayaran";
	}

	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'Data Pembayaran';
		return view('pages.data',$data);
	}
}
