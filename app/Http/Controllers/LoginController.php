<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Help;

class LoginController extends Controller
{
	public function main() {
		return Auth::user() ? redirect()->route('dashboard') : view('auth.login');
	}

	public function login(Request $request) {
		$rules = [
			'username' => 'required', 
			'password' => 'required', 
		];

		$message = [
			'username.required' => 'Username Wajib Diisi',
			'password.required' => 'Password Wajib Diisi',
		];

		$validate = Validator::make($request->all(), $rules, $message);
		if ($validate->fails()) {
			return Help::resHttp(['code'=>201,'message'=>$validate->errors()->all()[0]]);
		}

		if(Users::where('username',$request->username)->first() && Auth::attempt($request->only('username','password'))){
			return Help::resHttp(['code'=>200,'message'=>'Login successful!']);
		}
		return Help::resHttp(['code'=>201,'message'=>'Username atau password tidak valid!']);
	}

	public function logout(Request $request){
		$request->session()->flush();
		Auth::logout();
		return redirect()->route('auth.login');
	}
}
