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
				'name' => 'Petugas', // guru
				'username' => 'petugas',
				'email' => 'petugas@gmail.com',
				'password' => Hash::make('petugas'),
				'level' => 'petugas',
				'active' => true,
			],
		];
		DB::table('users')->insert($data);
	}
}
