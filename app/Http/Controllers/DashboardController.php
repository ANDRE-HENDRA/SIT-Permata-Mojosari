<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Dashboard";
	}

	public function main() {
		$data = $this->data;
		return view('pages.dashboard');
	}
}
