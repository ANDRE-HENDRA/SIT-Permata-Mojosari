<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Jenis Pembayaran";
	}

	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'Jenis Pembayaran';
		return view('pages.jenis',$data);
	}
}
