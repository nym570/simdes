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
		$this->pekerjaan();
		$this->pendidikan();
		$this->hubungan();
		$this->kategoriInfo();
		$this->role();
		$this->user();
		$this->desa();
		
		
		
		
	}

	private function pekerjaan(){
		$pekerjaan = [
			['name' => 'Belum/Tidak Bekerja'],
			['name' => 'Mengurus Rumah Tangga'],
			['name' => 'Pelajar/Mahasiswa'],
			['name' => 'Pensiunan'],
			['name' => 'Pewagai Negeri Sipil'],
			['name' => 'TNI/POLRI'],
			['name' => 'Karyawan Swasta/BUMN'],
			['name' => 'Wiraswasta/Pedagang'],
			['name' => 'Petani'],
			['name' => 'Buruh Tani'],
			['name' => 'Nelayan'],
			['name' => 'Peternak'],
			['name' => 'Jasa'],
			['name' => 'Pekerja Seni'],
			['name' => 'Lainnya'],
        ];
		DB::table('master_pekerjaan')->insert($pekerjaan);
	}

	private function pendidikan(){
		$pendidikan = [
            ['name'=>'Tidak / Belum Sekolah'],
			['name'=>'Belum Tamat SD/Sederajat'],
			['name'=>'Tamat SD / Sederajat'],
			['name'=>'SLTP/Sederajat'],
			['name'=>'SLTA / Sederajat'],
			['name'=>'Diploma I / II'],
			['name'=>'Akademi/ Diploma III/S. Muda'],
			['name'=>'Diploma IV/ Strata I'],
			['name'=>'Strata II'],
			['name'=>'Strata III'],
        ];
		DB::table('master_pendidikan')->insert($pendidikan);
	}

	private function kategoriInfo(){
		$info = [
            ['name'=>'Informasi Berkala'],
			['name'=>'Informasi Setiap Saat'],
			['name'=>'Informasi Serta Merta'],
			['name'=>'Lainnya'],
        ];
		DB::table('master_category_info')->insert($info);
	}

	
	private function hubungan(){
		$hubungan = [
            ['name'=>'Kepala Keluarga'],
			['name'=>'Suami/Istri'],
			['name'=>'Orang Tua'],
			['name'=>'Anak'],
			['name'=>'Menantu'],
			['name'=>'Cucu'],
			['name'=>'Mertua'],
			['name'=>'Famili Lain'],
			['name'=>'Pembantu'],
			['name'=>'Lainnya'],
        ];
		DB::table('master_hubungan')->insert($hubungan);
	}

	private function desa()
	{
		
		$desa = Desa::updateOrCreate
			([
				'id' => 1,
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

		// $users = User::factory(18)->create()->each(function ($user) {
        //     $user->assignRole('Warga'); 
        // });
		
	}
	private function warga()
	{
		Warga::factory(50)->create();
		
	}
	private function role()
	{
		Role::create(['name' => 'admin', 'guard_name'=> 'admin']);
		Role::create(['name' => 'warga']);
		Role::create(['name' => 'ppid']);
		Role::create(['name' => 'kependudukan']);
		Role::create(['name' => 'layanan']);
		Role::create(['name' => 'bpd']);
		Role::create(['name' => 'kepala dusun']);
		Role::create(['name' => 'ketua rw']);
		Role::create(['name' => 'ketua rt']);
		Role::create(['name' => 'kepala desa']);
	}
}
