<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;

class UserController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = "User";
	}

	public function main(Request $request) {
		$data = $this->data;
		$data['menuActive'] = 'User';
		if ($request->ajax()) {
			$data = Users::orderBy('name','asc')
				->where('level','petugas')
				->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('actions',function ($row) {
					$html = '';
					$html .= '<button type="button" class="btn btn-success btn-sm" onclick="edit('.$row->id.',this)">
									<i class="fa fa-pencil-alt" aria-hidden="true"></i>
									edit
								</button>';
					$html .= '<button type="button" class="btn btn-danger btn-sm ml-1" onclick="hapus('.$row->id.',this,`'.$row->username.'`)">
									<i class="fa fa-trash" aria-hidden="true"></i>
									hapus
								</button>';
					$html .= '<button type="button" class="btn btn-warning btn-sm text-white ml-1" onclick="reset('.$row->id.',this,`'.$row->username.'`)">
									<i class="fa fa-undo" aria-hidden="true"></i>
									Reset
								</button>';
					return $html;
				})
				->rawColumns(['actions'])
				->toJson();
		}
		return view('pages.master.user.main',$data);
	}

	public function form(Request $request) {
		$data = $this->data;
		if (!empty($request->id)) {
			if(!$data['user'] = Users::find($request->id)){
				return ['status'=>'fail','message'=>'Data pengguna tidak ditemukan'];
			}
		}
		$content = view('pages.master.user.form',$data)->render();
		return ['status'=>'success','response'=>$content];
	}

	public function store(Request $request) {
		$params = [
			'username' => 'required',
			'name' => 'required',
			'email' => 'required',
		];
		$messages = [
			'username.required' => 'Username Harus Diisi',
			'name.required' => 'Nama Harus Diisi',
			'email.required' => 'Email Harus Diisi',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		$user = Users::where([
				'username'=>$request->username
			])
			->when(!empty($request->id),function ($q) use ($request) {
				$q->where('id','!=',$request->id);
			})
			->first();
		if ($user && $user->username == $request->username) {
			return [
				'status'=>'fail',
				'message'=>"Sistem menemukan data user dengan Username yang sama $request->username"
			];
		}
		$user = Users::where([
			'email'=>$request->email
		])
		->when(!empty($request->id),function ($q) use ($request) {
			$q->where('id','!=',$request->id);
		})
		->first();
		if ($user && $user->email == $request->email) {
			return [
				'status'=>'fail',
				'message'=>"Sistem menemukan data user dengan Email yang sama $request->email"
			];
		}
		if (!empty($request->id)) {
			if (!$user = Users::find($request->id)) {
				return ['status'=>'fail','message'=>'Data user tidak ditemukan'];
			}
		} else {
			$user = new Users;
			$user->password = Hash::make($request->username);
		}
		$user->username = $request->username;
		$user->name = $request->name;
		$user->level = 'petugas';
		$user->active = true;
		$user->email = $request->email;
		if (!$user->save()) {
			return ['status'=>'error','message'=>'Gagal menyimpan data, coba lagi atau hubungi admin!'];
		}
		return ['status'=>'success','message'=>'Berhasil menyimpan data!'];
	}

	public function delete(Request $request) {
		$params = [
			'id' => 'required',
		];
		$messages = [
			'id.required' => 'Data Tidak Valid',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		if (!$user = Users::find($request->id)) {
			return ['status'=>'fail','message'=>'Data user tidak ditemukan'];
		}
		if (!$user->delete()) {
			return ['status'=>'error','message'=>'Gagal menghapus data, coba lagi atau hubungi admin!'];
		}
		// if (isset($request->permanent) && $request->permanent) {
		// }
		return ['status'=>'success','message'=>'Berhasil menghapus data!'];
	}

	public function reset(Request $request) {
		$params = [
			'id' => 'required',
		];
		$messages = [
			'id.required' => 'Data Tidak Valid',
		];

		$validator = Validator::make($request->all(),$params,$messages);
		if ($validator->fails()) {
			foreach ($validator->errors()->toArray() as $key => $val) {
				$msg = $val[0]; # Get validation messages, only one
				break;
			}
			return ['status' => 'fail', 'message' => $msg];
		}
		if (!$user = Users::find($request->id)) {
			return ['status'=>'fail','message'=>'Data user tidak ditemukan'];
		}
		$user->password = Hash::make($user->username);
		if (!$user->save()) {
			return ['status'=>'error','message'=>'Gagal mereset password, coba lagi atau hubungi admin!'];
		}
		return ['status'=>'success','message'=>'Berhasil mereset password!'];
	}
}
