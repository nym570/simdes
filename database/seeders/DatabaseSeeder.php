<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warga;
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
		
		$this->role();
		$this->warga();
		$this->user();
		$this->desa();
		
		
		
		
	}

	private function desa()
	{
		$role = Role::create(['name' => 'kepala desa','category' => 'pemimpin','status' => 'desa']);
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
				'kepala_desa' => $role->id,
			]);
		
		
	}


	private function user()
	{
		//User::factory(10)->create();
		$admin1 = Admin::updateOrCreate
			([
				'username' => 'admin1',
				'nama' => 'Admin Desa',
				'email' => 'simdes794@gmail.com',
				'password' => Hash::make('admin12345'),
			]);
		$admin1->assignRole('admin');
		$admin2 = Admin::updateOrCreate
			([
				'username' => 'admin2',
				'nama' => 'Admin lain',
				'email' => '222011794@stis.ac.id',
				'password' => Hash::make('admin12345'),
			]);
		$admin2->assignRole('admin');

		$kades = User::updateOrCreate
			([
				'username' => 'laili',
				'nik' => Warga::factory(1)->create()->value('nik'),
				'email' => 'laililili45@gmail.com',
				'password' => Hash::make('password12345'),
			]);
		$kades->assignRole(['warga']);

		$users = User::factory(18)->create()->each(function ($user) {
            $user->assignRole('Warga'); 
        });
		
	}
	private function warga()
	{
		Warga::factory(50)->create();
		
	}
	private function role()
	{
		Role::create(['name' => 'admin','category' => 'admin','status' => 'admin', 'guard_name'=> 'admin']);
		Role::create(['name' => 'warga','category' => 'warga','status' => 'warga',]);
		Role::create(['name' => 'ppid','category' => 'ppid','status' => 'desa']);
		Role::create(['name' => 'kependudukan','category' => 'kependudukan','status' => 'desa']);
		Role::create(['name' => 'layanan','category' => 'layanan','status' => 'desa']);
		Role::create(['name' => 'bpd','category' => 'bpd','status' => 'desa']);
		
	}
}
