<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use Illuminate\Http\Request;
use DataTables;

class ActivityLogController extends Controller
{
	protected $data;

	public function __construct() {
		$this->data['title'] = 'Activity Log';
	}

	public function main(Request $request) {
		if ($request->ajax()) {
			$tglAwal = date('Y-m-d 00:00:00',strtotime(explode(' - ',$request->jarakTanggal)[0]));
			$tglAkhir = date('Y-m-d 23:59:59',strtotime(explode(' - ',$request->jarakTanggal)[1]));
			$data = Aktivitas::orderBy('created_at','desc')
				->with('user')
				->whereBetween('created_at',[$tglAwal,$tglAkhir])
				->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('user',function ($row) {
					return $row->nama_user.' ('.$row->user_id.')';
				})
				->addColumn('tanggal',function ($row) {
					return $row->created_at;
				})
				->toJson();
		}
		$data = $this->data;
		$data['menuActive'] = 'Activity Log';
		return view('pages.activity-log',$data);
	}
}
