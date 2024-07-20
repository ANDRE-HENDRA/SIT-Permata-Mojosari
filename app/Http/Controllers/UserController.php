<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "User";
	}

	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'User';
		$data['users'] = Users::get();
		return view('pages.user',$data);
	}
}
