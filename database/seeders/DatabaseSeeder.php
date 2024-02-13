<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Desa;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		
		$this->desa();
		$this->role();
		$this->user();
		
	}

	private function desa()
	{
		$desa = Desa::updateOrCreate
			([
				'kode_wilayah' => '',
				'desa' => '',
				'kecamatan' => '',
				'kabupaten' => '',
				'provinsi' => '',
				'alamat_kantor' => '',
				'email_desa' => '',
				'no_telp' => '',
				'deskripsi' => '',
			]);
		
		
	}


	private function user()
	{
		//User::factory(10)->create();
		$admin = Admin::updateOrCreate
			([
				'username' => 'admin',
				'nik' => '3515000000000000',
				'no_kk' => '3515000000000000',
				'nama' => 'Admin Desa',
				'email' => 'simdes794@gmail.com',
				'no_telp' => '62895621061193',
				'password' => Hash::make('password'),
			]);
		$admin->assignRole('admin');

		$kades = User::updateOrCreate
			([
				'username' => 'laili',
				'nik' => '3515000000000001',
				'no_kk' => '3515000000000001',
				'nama' => 'Laili Fatqulia',
				'email' => 'laililili45@gmail.com',
				'no_telp' => '62895621061193',
				'password' => Hash::make('password'),
			]);
		$kades->assignRole(['warga']);

		$users = User::factory(18)->create()->each(function ($user) {
            $user->assignRole('Warga'); 
        });
		
	}
	private function role()
	{
		Role::create(['name' => 'admin','category' => 'admin', 'guard_name'=> 'admin']);
		Role::create(['name' => 'warga','category' => 'warga']);
		Role::create(['name' => 'kepala desa','category' => 'kepala desa']);
		Role::create(['name' => 'ppid','category' => 'aparat desa']);
		Role::create(['name' => 'pemerintahan','category' => 'aparat desa']);
		Role::create(['name' => 'layanan','category' => 'aparat desa']);
		Role::create(['name' => 'bpd','category' => 'aparat desa']);
		
	}
}
