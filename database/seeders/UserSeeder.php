<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$data = [
			[
				'name' => 'Administrator', // admin
				'username' => 'admin',
				'email' => 'admin@gmail.com',
				'password' => Hash::make('admin'),
				'level' => 'administrator',
				'active' => true,
			],
			[
				'name' => 'Kepala Sekolah', // kepala sekolah
				'username' => 'kepalasekolah',
				'email' => 'kepalasekolah@gmail.com',
				'password' => Hash::make('kepalasekolah'),
				'level' => 'kepala_sekolah',
				'active' => true,
			],
			[
				'name' => 'Guru TU', // guru
				'username' => 'gurutu',
				'email' => 'gurutu@gmail.com',
				'password' => Hash::make('gurutu'),
				'level' => 'guru_tu',
				'active' => true,
			],
		];
		DB::table('users')->insert($data);
	}
}
