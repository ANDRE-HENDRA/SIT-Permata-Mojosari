<?php

namespace App\Helpers;

use App\Models\Aktivitas;
use Auth;
class Helpers
{
	public static function resHttp($data = [])
	{
		$keyData = ['message', 'code', 'response'];
		$arr = [];
		foreach ($keyData as $key => $val) {
			$arr[$val] = isset($data[$val]) ? $data[$val] : ( # Cek key, apakah sudah di set
				$val == 'code' ? 500 : ($val == 'message' ? '-' : []));
		}
		$code = $arr['code'];
		$msg = $arr['message'];

		$metadata = [
			'code'    => $arr['code'],
			'message' => $arr['message'],
		];
		$payload['metadata'] = $metadata;
		$payload['response'] = $arr['response'];
		return response()->json($payload, $code);
	}

	public static function resMsg($message = 'Terjadi Kesalahan Sistem', $code = 500)
	{
		return response()->json(['message' => $message, 'code' => $code], $code);
	}

	public static function bulanIndo($param) {
		switch ($param) {
			case '01':
				return 'Januari';
				break;
			case '02':
				return 'Februari';
				break;
			case '03':
				return 'Maret';
				break;
			case '04':
				return 'April';
				break;
			case '05':
				return 'Mei';
				break;
			case '06':
				return 'Juni';
				break;
			case '07':
				return 'Juli';
				break;
			case '08':
				return 'Agustus';
				break;
			case '09':
				return 'September';
				break;
			case '10':
				return 'Oktober';
				break;
			case '11':
				return 'November';
				break;
			case '12':
				return 'Desember';
				break;
			
			default:
				return false;
				break;
		}
	}

	public static function currencyFormatDecimal($angka)
	{
		$hasil_rupiah = 'Rp. ' . number_format((float) $angka, 0, ',', '.');
		return $hasil_rupiah;
	}

	public static function storeLog($keterangan) {
		$log = new Aktivitas;
		$log->user_id = Auth::user()->id;
		$log->nama_user = Auth::user()->name;
		$log->keterangan = $keterangan;
		return $log->save();
	}
}
