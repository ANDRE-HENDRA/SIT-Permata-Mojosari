<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PengaturanAkunController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "Pengaturan Akun";
	}

	public function main() {
		$data = $this->data;
		$data['menuActive'] = 'Pengaturan Akun';
		$data['user'] = Users::find(Auth::user()->id);
		return view('pages.pengaturan-akun',$data);
	}

	public function store(Request $request) {
		$params = [
			'name' => 'required',
			'password' => 'required',
		];
		$message = [
			'name.required' => 'Nama harus diisi',
			'password.required' => 'Password harus diisi',
		];
		$validator = Validator::make($request->all(), $params, $message);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		if (!$user = Users::find(Auth::user()->id)) {
			return ['status' => 'fail', 'message' => 'Gagal mengupdate, data tidak ditemukan'];
		}
		if(!Hash::check($request->password,$user->password)){
			return ['status' => 'fail', 'message' => 'Gagal mengupdate, password yang anda masukkan salah'];
		}
		$user->name = $request->name;

		if (!$user->save()) {
			return ['status' => 'fail', 'message' => 'Gagal menyimpan data'];
		}
		return ['status' => 'success', 'message' => 'Berhasil menyimpan!'];
	}

	public function ubahPassword(Request $request) {
		$params = [
			'password_lama' => 'required',
			'password_baru' => 'required',
			'ulangi_password_baru' => 'required',
		];
		$message = [
			'password_lama.required' => 'Password Lama harus diisi',
			'password_baru.required' => 'Password Baru harus diisi',
			'ulangi_password_baru.required' => 'Ulangi Password Baru harus diisi',
		];
		$validator = Validator::make($request->all(), $params, $message);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		if (!$user = Users::find(Auth::user()->id)) {
			return ['status' => 'fail', 'message' => 'Gagal mengupdate, data tidak ditemukan'];
		}
		if(!Hash::check($request->password_lama,$user->password)){
			return ['status' => 'fail', 'message' => 'Password lama anda tidak sesuai / tidak valid'];
		}
		if($request->password_baru != $request->ulangi_password_baru){
			return ['status' => 'fail', 'message' => 'Password baru yang anda masukkan tidak sama'];
		}
		$user->password = Hash::make($request->password_baru);
		if (!$user->save()) {
			return ['status' => 'fail', 'message' => 'Gagal menyimpan data'];
		}
		return ['status' => 'success', 'message' => 'Berhasil menyimpan!'];
	}
}
