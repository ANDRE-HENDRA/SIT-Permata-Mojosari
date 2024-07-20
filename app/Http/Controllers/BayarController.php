<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BayarController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Pembayaran";
	}

	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'Pembayaran';
		return view('pages.bayar',$data);
	}
}
