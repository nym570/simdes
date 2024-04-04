<?php

use App\Http\Controllers\User_Role\UserController;
use App\Http\Controllers\User_Role\AdminController;
use App\Http\Controllers\User_Role\RoleController;
use App\Http\Controllers\Desa\DesaController;
use App\Http\Controllers\Desa\PemerintahanController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\LogActivityController;
use App\Http\Controllers\Desa\WilayahIndoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Desa\MasterDesaController;
use App\Http\Controllers\Warga\WargaController;
use App\Http\Controllers\Warga\RutaController;
use App\Http\Controllers\Warga\Dinamika\KelahiranController;
use App\Http\Controllers\Warga\Dinamika\KematianController;
use App\Http\Controllers\Warga\Dinamika\KepindahanController;
use App\Http\Controllers\Warga\Dinamika\KedatanganController;
use App\Http\Controllers\Pengajuan\PengajuanDinamika;
use App\Http\Controllers\Pengajuan\PengajuanAspirasi;
use App\Http\Controllers\Layanan\AspirasiController;
use App\Http\Controllers\Layanan\BalasAspirasiController;
use App\Http\Controllers\Layanan\InfoPublikController;
use App\Http\Controllers\Layanan\PengajuanInfoPublikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\StatistikWargaController;
use App\Http\Controllers\Auth\ProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [DashboardController::class,'index'])->name('home');
Route::get('/dusun-count', [DashboardController::class,'dusunCount'])->name('warga-dusun-count');
Route::get('/rw-count', [DashboardController::class,'rwCount'])->name('warga-rw-count');



Route::controller(StatistikWargaController::class)->name('statistik.warga.')->group(function () {
	Route::name('agama.')->group(function () {
		Route::get('/statistik/warga/agama', 'agama')->name('index');
		Route::get('/statistik/warga/agama/dusun', 'agamaDusun')->name('dusun-count');
		Route::get('/statistik/warga/agama/rw', 'agamaRW')->name('rw-count');
		Route::get('/statistik/warga/agama/rt', 'agamaRT')->name('rt-count');
	});
	Route::name('pendidikan.')->group(function () {
		Route::get('/statistik/warga/pendidikan', 'pendidikan')->name('index');
		Route::get('/statistik/warga/pendidikan/dusun', 'pendidikanDusun')->name('dusun-count');
		Route::get('/statistik/warga/pendidikan/rw', 'pendidikanRW')->name('rw-count');
		Route::get('/statistik/warga/pendidikan/rt', 'pendidikanRT')->name('rt-count');
	});
	Route::name('pekerjaan.')->group(function () {
		Route::get('/statistik/warga/pekerjaan', 'pekerjaan')->name('index');
		Route::get('/statistik/warga/pekerjaan/dusun', 'pekerjaanDusun')->name('dusun-count');
		Route::get('/statistik/warga/pekerjaan/rw', 'pekerjaanRW')->name('rw-count');
		Route::get('/statistik/warga/pekerjaan/rt', 'pekerjaanRT')->name('rt-count');
	});
	Route::name('gol_darah.')->group(function () {
		Route::get('/statistik/warga/gol_darah', 'gol_darah')->name('index');
		Route::get('/statistik/warga/gol_darah/dusun', 'gol_darahDusun')->name('dusun-count');
		Route::get('/statistik/warga/gol_darah/rw', 'gol_darahRW')->name('rw-count');
		Route::get('/statistik/warga/gol_darah/rt', 'gol_darahRT')->name('rt-count');
	});
	Route::name('ktp_desa.')->group(function () {
		Route::get('/statistik/warga/ktp_desa', 'ktp_desa')->name('index');
		Route::get('/statistik/warga/ktp_desa/dusun', 'ktp_desaDusun')->name('dusun-count');
		Route::get('/statistik/warga/ktp_desa/rw', 'ktp_desaRW')->name('rw-count');
		Route::get('/statistik/warga/ktp_desa/rt', 'ktp_desaRT')->name('rt-count');
	});
	Route::name('jenis_kelamin.')->group(function () {
		Route::get('/statistik/warga/jenis_kelamin', 'jenis_kelamin')->name('index');
		Route::get('/statistik/warga/jenis_kelamin/dusun', 'jenis_kelaminDusun')->name('dusun-count');
		Route::get('/statistik/warga/jenis_kelamin/rw', 'jenis_kelaminRW')->name('rw-count');
		Route::get('/statistik/warga/jenis_kelamin/rt', 'jenis_kelaminRT')->name('rt-count');
	});
	Route::name('umur.')->group(function () {
		Route::get('/statistik/warga/umur', 'umur')->name('index');
		Route::get('/statistik/warga/umur/dusun', 'umurDusun')->name('dusun-count');
		Route::get('/statistik/warga/umur/rw', 'umurRW')->name('rw-count');
		Route::get('/statistik/warga/umur/rt', 'umurRT')->name('rt-count');
	});

});


Route::get('/boot', [DashboardController::class,'boot'])->name('admin.boot');


Route::middleware(['admin.auth','admin.verified'])->group(function () {
	Route::get('/admin', [AdminHomeController::class,'index'])->name('admin.home');
	Route::get('/boot/config', [DashboardController::class,'config'])->name('admin.boot.config');
	Route::controller(AdminController::class)->name('admin-list.')->group(function () {
		Route::get('/admin/admin', 'index')->name('index');
		Route::post('/admin/admin', 'store')->name('store');
		Route::post('/admin/admin/import', 'import')->name('import');
		Route::get('/admin/admin/{admin}/get', 'get')->name('get');
		Route::put('/admin/admin/{admin}/status', 'status')->name('status');
		Route::put('/admin/admin/{admin}/reset-pass', 'resetPass')->name('reset-pass');
		Route::put('/admin/admin/{admin}/update', 'update')->name('update');
	});
	Route::controller(DesaController::class)->name('m.desa.')->group(function () {
		Route::get('/admin/desa', 'index')->name('index');
		Route::get('/admin/desa/get', 'get')->name('get');
		Route::put('/admin/desa/kades', 'kades')->name('kades');
		Route::put('/admin/desa/kades/hapus', 'kadesDelete')->name('kades.hapus');
		Route::put('/admin/desa/{desa}/update', 'update')->name('update');
		Route::put('/admin/desa/{desa}/update-deskripsi', 'updateDesc')->name('deskripsi');
	});
	Route::controller(DesaController::class)->name('m.lkd.')->group(function () {
		Route::get('/admin/desa/kemasyarakatan', 'lkd')->name('index');
		Route::get('/admin/desa/kemasyarakatan/{dusun}/dusun', 'dusun')->name('dusun.get');
		Route::put('/admin/desa/kemasyarakatan/{dusun}/dusun/pemimpin', 'kadus')->name('dusun.kadus');
		Route::put('/admin/desa/kemasyarakatan/{dusun}/dusun/pemimpin/hapus', 'kadusDelete')->name('dusun.kadus.hapus');
		Route::get('/admin/desa/kemasyarakatan/{rw}/rw', 'rw')->name('rw.get');
		Route::put('/admin/desa/kemasyarakatan/{rw}/rw/pemimpin', 'ketuaRW')->name('rw.pemimpin');
		Route::put('/admin/desa/kemasyarakatan/{rw}/rw/pemimpin/hapus', 'ketuaRWDelete')->name('rw.pemimpin.hapus');
		Route::get('/admin/desa/kemasyarakatan/{rt}/rt', 'rt')->name('rt.get');
		Route::put('/admin/desa/kemasyarakatan/{rt}/rt/pemimpin', 'ketuaRT')->name('rt.pemimpin');
		Route::put('/admin/desa/kemasyarakatan/{rt}/rt/pemimpin/hapus', 'ketuaRTDelete')->name('rt.pemimpin.hapus');
		Route::get('/admin/desa/kemasyarakatan/dusun-list', 'getDusun')->name('getDusun');
		Route::get('/admin/desa/kemasyarakatan/rw-list', 'getRW')->name('getRW');
		Route::get('/admin/desa/kemasyarakatan/rt-list', 'getRT')->name('getRT');
		Route::post('/admin/desa/kemasyarakatan/dusun', 'storeDusun')->name('dusun.store');
		Route::post('/admin/desa/kemasyarakatan/rw', 'storeRW')->name('rw.store');
		Route::post('/admin/desa/kemasyarakatan/rt', 'storeRT')->name('rt.store');
	});
	Route::controller(PemerintahanController::class)->name('m.pemerintahan.')->group(function () {
		Route::get('/admin/pemerintahan', 'index')->name('index');
		Route::post('/admin/pemerintahan', 'store')->name('store');
		Route::get('/admin/pemerintahan/{pemerintahan}/show', 'show')->name('show');
		Route::put('/admin/pemerintahan/{pemerintahan}/update', 'update')->name('update');
		Route::delete('/admin/pemerintahan/{pemerintahan}/delete', 'delete')->name('delete');
	});
	Route::controller(LogActivityController::class)->name('log.')->group(function () {
		Route::get('/admin/log', 'index')->name('index');
	});
	
	Route::controller(RoleController::class)->name('roles.')->group(function () {
		Route::get('/admin/roles', 'index')->name('index');
		Route::get('/admin/roles/user-list', 'userWithoutPemimpin')->name('user-list.pemimpin');
		Route::get('/admin/roles/{role}/show', 'show')->name('show');
		Route::post('/admin/roles/{user}/update', 'update')->name('update');
		Route::post('/admin/roles/add-one', 'addOne')->name('add-one');
		Route::post('/admin/roles/add-many', 'addMany')->name('add-many');
	});
	Route::controller(UserController::class)->name('users.')->group(function () {
		Route::get('/admin/users', 'index')->name('index');
		Route::get('/admin/users/{user}/get', 'get')->name('get');
		Route::post('/admin/users', 'store')->name('store');
		Route::post('/admin/users/import', 'import')->name('import');
		Route::post('/admin/users/{user}/reset-pass', 'reset-pass')->name('reset-pass');
		Route::get('/admin/users/{user}/show', 'show')->name('show');
		Route::get('/admin/users/{user}/edit', 'edit')->name('edit');
		Route::put('/admin/users/{user}/update', 'update')->name('update');
		Route::put('/admin/users/{user}/status', 'status')->name('status');
		Route::delete('/admin/users/{user}/delete', 'delete')->name('delete');
		Route::post('/users/{user}/del-role', 'deleteRole')->name('hapusRole');
		Route::post('/users/{user}/role', 'role')->name('role');
		Route::get('/admin/users/dusun-count', 'dusunCount')->name('dusun-count');
		Route::get('/admin/users/rw-count', 'rwCount')->name('rw-count');
	});
});

Route::middleware(['auth','verified'])->group(function () {
	Route::middleware(['role:ppid|kepala desa'])->group(function () {
		Route::controller(InfoPublikController::class)->name('info-publik.')->group(function () {
			Route::get('/info-publik', 'index')->name('index');
			Route::get('/info-publik/{info}/get', 'get')->name('get');
			Route::put('/info-publik/{info}/status', 'status')->name('status');
			Route::delete('/info-publik/{info}/delete', 'delete')->name('delete');
			Route::post('/info-publik', 'store')->name('store');
		});
		Route::controller(PengajuanInfoPublikController::class)->name('pengajuan-info-manajemen.')->group(function () {
			Route::get('/pengajuan-info-manajemen', 'list')->name('index');
		});
	});
	Route::middleware(['role:ketua rt|ketua rw|bpd|kepala dusun|kepala desa'])->group(function () {
		Route::controller(AspirasiController::class)->name('aspirasi.')->group(function () {
			Route::get('/aspirasi', 'index')->name('index');
			Route::get('/aspirasi/{aspirasi}/show', 'show')->name('show');
			Route::put('/aspirasi/{aspirasi}/status', 'status')->name('status');
		});
	});

	Route::middleware(['role:ketua rt|ketua rw|kependudukan|kepala dusun|kepala desa'])->group(function () {
		
		Route::controller(WargaController::class)->name('warga.')->group(function () {
			Route::get('warga/{warga}/get', 'get')->name('get');
			Route::get('/warga', 'index')->name('index');
			Route::get('warga/get-warga', 'getWargaHidup')->name('get-warga');
			Route::get('/warga/{warga}', 'show')->name('show');
			Route::post('/warga/get-dokumen', 'getDokumen')->name('get-dokumen');
			Route::post('/warga/{warga}/message', 'message')->name('message');
			Route::post('/warga/{warga}/message-rt', 'messageRT')->name('message.rt');
			
		});
		Route::controller(RutaController::class)->name('ruta.')->group(function () {
			Route::get('/ruta', 'index')->name('index');
			Route::get('/ruta/{ruta}', 'show')->name('show');
			Route::get('/ruta/{ruta}/edit', 'edit')->name('edit');
		});
		Route::controller(KelahiranController::class)->name('dinamika.kelahiran.')->group(function () {
			Route::get('/dinamika/kelahiran', 'index')->name('index');
			Route::get('/kelahiran/{lahir}/get', 'get')->name('get');
		});
		Route::controller(KematianController::class)->name('dinamika.kematian.')->group(function () {
			Route::get('/dinamika/kematian', 'index')->name('index');
			Route::get('/kematian/{mati}/get', 'get')->name('get');
		});

		Route::controller(KedatanganController::class)->name('dinamika.kedatangan.')->group(function () {
			Route::get('/dinamika/kedatangan', 'index')->name('index');
			Route::get('/kedatangan/{datang}/get', 'get')->name('get');
		});
		Route::controller(KepindahanController::class)->name('dinamika.kepindahan.')->group(function () {
			Route::get('/dinamika/kepindahan', 'index')->name('index');
			Route::get('/kepindahan/{pindah}/get', 'get')->name('get');
		});
	});
	Route::middleware(['role:ketua rt|kependudukan'])->group(function () {
		Route::controller(WargaController::class)->name('warga.')->group(function () {
			Route::put('/warga/{warga}/dokumen', 'dokumen')->name('dokumen');
			
			Route::put('/warga/{warga}/status', 'status')->name('status');
			Route::put('/warga/{warga}/domisili', 'domisili')->name('domisili');
			
		});
		

	});
	Route::middleware(['role:ketua rt'])->group(function () {
		Route::controller(WargaController::class)->name('warga.')->group(function () {
			Route::post('/warga', 'store')->name('store');
			Route::put('/warga/{warga}/update', 'update')->name('update');
			
			Route::post('/warga/import', 'import')->name('import');
		});
		Route::controller(RutaController::class)->group(function () {
			Route::get('/get-warga-nonruta', 'getWargaNonRuta')->name('get-warga-nonruta');
			Route::get('/get-kepala-ruta', 'getKepalaRuta')->name('get-kepala-ruta');
		});
		Route::controller(RutaController::class)->name('ruta.')->group(function () {
			Route::post('/ruta', 'store')->name('store');
			Route::get('/ruta/{ruta}/edit', 'edit')->name('edit');
			Route::put('/ruta/{ruta}/update', 'update')->name('update');
			Route::put('/ruta/anggota-ruta/{anggota_ruta}/update', 'anggotaUpdate')->name('anggota.update');
			Route::delete('/ruta/{ruta}/delete', 'destroy')->name('delete');
			Route::delete('/ruta/anggota-ruta/{anggota_ruta}/delete', 'anggotaDestroy')->name('anggota.delete');
			Route::post('/ruta/{ruta}/anggota', 'storeAnggota')->name('anggota.store');
			Route::post('/ruta/{ruta}/kepala', 'updateKepala')->name('anggota.update-kepala');
			Route::post('/ruta/import', 'import')->name('import');
		});
		Route::controller(KelahiranController::class)->name('dinamika.kelahiran.')->group(function () {
			Route::post('/dinamika/kelahiran', 'store')->name('store');
			Route::put('/dinamika/kelahiran/{lahir}/verif', 'verifikasi')->name('verifikasi');
			Route::post('/dinamika/kelahiran/{lahir}/tolak', 'tolak')->name('tolak');
		});
		Route::controller(KematianController::class)->name('dinamika.kematian.')->group(function () {
			Route::post('/dinamika/kematian', 'store')->name('store');
			Route::put('/dinamika/kematian/{mati}/verif', 'verifikasi')->name('verifikasi');
			Route::post('/dinamika/kematian/{mati}/tolak', 'tolak')->name('tolak');
		});
		Route::controller(KepindahanController::class)->name('dinamika.kepindahan.')->group(function () {
			Route::post('/dinamika/kepindahan', 'store')->name('store');
			Route::put('/dinamika/kepindahan/{pindah}/verif', 'verifikasi')->name('verifikasi');
			Route::post('/dinamika/kepindahan/{pindah}/tolak', 'tolak')->name('tolak');
		});
		Route::controller(KedatanganController::class)->name('dinamika.kedatangan.')->group(function () {
			
			Route::get('/dinamika/kedatangan/create', 'create')->name('create');
			Route::post('/dinamika/kedatangan/pendatang', 'pendatang')->name('pendatang');
			Route::post('/dinamika/kedatangan', 'store')->name('store');
			Route::put('/dinamika/kedatangan/{datang}/verif', 'verifikasi')->name('verifikasi');
			
		});
		
	});

	Route::middleware(['role:warga'])->name('pengajuan.warga.')->group(function () {
		Route::controller(PengajuanAspirasi::class)->name('aspirasi.')->group(function () {
			Route::get('/pengajuan/aspirasi', 'index')->name('index');
			Route::post('/pengajuan/aspirasi', 'store')->name('store');
			Route::get('/pengajuan/aspirasi/{aspirasi}/show', 'show')->name('show');
			
		});
		Route::controller(PengajuanDinamika::class)->name('kependudukan.')->group(function () {
			Route::get('/pengajuan/kependudukan', 'index')->name('index');
			Route::post('/pengajuan/kelahiran', 'kelahiran')->name('kelahiran.store');
			Route::post('/pengajuan/kematian', 'kematian')->name('kematian.store');
			Route::post('/pengajuan/kepindahan', 'kepindahan')->name('kepindahan.store');
			
		});
		Route::name('ruta.')->group(function () {
			Route::controller(PengajuanDinamika::class)->group(function(){
				Route::get('/pengajuan/kependudukan/{ruta}/ruta', 'ruta')->name('index');
				
				Route::get('/pengajuan/kependudukan/ruta/warga/{warga}', 'anggotaShow')->name('anggota.warga.show');
			});
			Route::controller(RutaController::class)->group(function(){
				Route::put('/pengajuan/kependudukan/{ruta}/update', 'update')->name('update');
			});
			
			
			Route::name('anggota.')->group(function () {
				Route::controller(WargaController::class)->name('warga.')->group(function () {
					
					Route::get('/pengajuan/kependudukan/ruta/warga/{warga}/get', 'get')->name('get');
					Route::post('/pengajuan/kependudukan/ruta/warga/get-dokumen', 'getDokumen')->name('get-dokumen');
					Route::put('/pengajuan/kependudukan/ruta/warga/{warga}/dokumen', 'dokumen')->name('dokumen');
					Route::put('/pengajuan/kependudukan/ruta/warga/{warga}/update', 'update')->name('update');
				});
				Route::controller(RutaController::class)->group(function () {

					Route::put('/ruta/anggota/{anggota_ruta}/update', 'anggotaUpdate')->name('update');
					Route::delete('/ruta/anggota/{anggota_ruta}/delete', 'anggotaDestroy')->name('delete');
				});
			});
		});
		

	});
	
	Route::name('profil.')->group(function () {
		Route::controller(ProfilController::class)->group(function () {
			Route::get('/profil', 'index')->name('index');
			
		});
		Route::controller(WargaController::class)->name('warga.')->group(function () {
			Route::get('/profil/warga/{warga}/get', 'get')->name('get');
			Route::post('/profil/warga/get-dokumen', 'getDokumen')->name('get-dokumen');
			Route::put('/profil/warga/{warga}/dokumen', 'dokumen')->name('dokumen');
			Route::put('/profil/warga/{warga}/update', 'update')->name('update');
		});

		Route::controller(UserController::class)->name('user.')->group(function () {
			Route::get('/profil/user/{warga}/get', 'get')->name('get');
			Route::put('/profil/user/{user}/update', 'update')->name('update');
			Route::put('/profil/user/{user}/password', 'password')->name('password');
		});
		
	});
		
	Route::controller(RutaController::class)->name('ruta.')->group(function () {
		Route::post('/ruta/anggota', 'getAnggota')->name('anggota-get');
	});

	Route::controller(BalasAspirasiController::class)->name('balas_aspirasi.')->group(function () {
		Route::post('/balas', 'store')->name('store');
	
		
	});
});



Route::controller(UserController::class)->name('users.')->group(function () {
	Route::post('/users/check-nik', 'validateNIK')->name('nik');
	Route::post('/users/check-kk', 'validateKK')->name('kk');
});
Route::controller(WargaController::class)->group(function () {
	Route::get('/get-warga', 'getWargaHidup')->name('get-warga');
});


Route::controller(DesaController::class)->name('desa.')->group(function () {
	Route::get('/desa', 'show')->name('show');
});

Route::controller(PemerintahanController::class)->name('pemerintahan.')->group(function () {
	Route::get('pemerintahan/get', 'get')->name('get');

	
});

Route::controller(InfoPublikController::class)->name('info.')->group(function () {
	Route::get('/info', 'show')->name('show');
	Route::get('/info/{info}/get', 'get')->name('get');
});
Route::controller(PengajuanInfoPublikController::class)->name('pengajuan-info.')->group(function () {
	Route::get('/pengajuan-info', 'index')->name('index');
	Route::post('/pengajuan-info/store', 'store')->name('buat');
	Route::post('/pengajuan-info/cek', 'cek')->name('cek');
	Route::get('/pengajuan-info/{mohon_info}/show', 'show')->name('info');
});

Route::bind('role', function ($id, $route) {
    return Hashids::decode($id)[0];
});



Route::controller(WilayahIndoController::class)->name('wilayah.')->group(function () {
	Route::get('/get-prov', 'getProv')->name('get-prov');
	Route::get('/get-kab', 'getKab')->name('get-kab');
	Route::get('/get-kec', 'getKec')->name('get-kec');
	Route::get('/get-des', 'getDes')->name('get-des');
});
Route::controller(MasterDesaController::class)->name('master-desa.')->group(function () {
	Route::get('/desa/get-dusun', 'getDusun')->name('get-dusun');
	Route::get('/desa/get-RW', 'getRW')->name('get-rw');
	Route::get('/desa/get-RT', 'getRT')->name('get-rt');
});

Route::controller(MasterController::class)->name('master.')->group(function () {
	Route::get('/master/get-hubungan', 'getHubungan')->name('ruta.get-hubungan');
	Route::get('/master/get-pendidikan', 'getPendidikan')->name('identitas.get-pendidikan');
	Route::get('/master/get-pekerjaan', 'getPekerjaan')->name('identitas.get-pekerjaan');
	Route::get('/master/get-kategori', 'getKategori')->name('aspirasi.get-kategori');
	Route::get('/master/get-kategori-info', 'getInfo')->name('info-publik.get-kategori');
});


require 'auth.php';
