<?php

use App\Http\Controllers\User_Role\UserController;
use App\Http\Controllers\User_Role\AdminController;
use App\Http\Controllers\User_Role\RoleController;
use App\Http\Controllers\Desa\DesaController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\LogActivityController;
use App\Http\Controllers\Desa\WilayahIndoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Desa\MasterDesaController;
use App\Http\Controllers\Warga\WargaController;
use App\Http\Controllers\Warga\RutaController;
use App\Http\Controllers\Warga\Dinamika\KematianController;
use App\Http\Controllers\Warga\Dinamika\KepindahanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;

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

Route::get('/admin', [AdminHomeController::class,'index'])->name('admin.home')->middleware(['admin.auth','admin.verified']);

Route::get('/boot', [DashboardController::class,'boot'])->name('admin.boot')->middleware(['admin.auth','admin.verified']);




Route::controller(UserController::class)->middleware(['admin.auth','admin.verified'])->name('users.')->group(function () {
	Route::get('/admin/users', 'index')->name('index');
	Route::post('/admin/users', 'store')->name('store');
	Route::post('/admin/users/{user}/reset-pass', 'reset-pass')->name('reset-pass');
	Route::get('/admin/users/{user}/show', 'show')->name('show');
	Route::get('/admin/users/{user}/edit', 'edit')->name('edit');
	Route::put('/admin/users/{user}/update', 'update')->name('update');
	Route::put('/admin/users/{user}/status', 'status')->name('status');
	Route::delete('/admin/users/{user}/delete', 'delete')->name('delete');
	Route::post('/users/{user}/del-role', 'deleteRole')->name('hapusRole');
	Route::post('/users/{user}/role', 'role')->name('role');
});

Route::controller(UserController::class)->name('users.')->group(function () {
	Route::post('/users/check-nik', 'validateNIK')->name('nik');
	Route::post('/users/check-kk', 'validateKK')->name('kk');
});


Route::controller(AdminController::class)->middleware(['admin.auth','admin.verified'])->name('admin-list.')->group(function () {
	Route::get('/admin/admin', 'index')->name('index');
	Route::post('/admin/admin', 'store')->name('store');
	Route::put('/admin/admin/{admin}/status', 'status')->name('status');
});

Route::controller(DesaController::class)->middleware(['admin.auth','admin.verified'])->name('m.desa.')->group(function () {
	Route::get('/admin/desa', 'index')->name('index');
	Route::put('/admin/desa/{desa}/update', 'update')->name('update');
	Route::put('/admin/desa/{desa}/update-deskripsi', 'updateDesc')->name('deskripsi');

	
});
Route::controller(DesaController::class)->middleware(['admin.auth','admin.verified'])->name('m.lkd.')->group(function () {
	Route::get('/admin/desa/kemasyarakatan', 'lkd')->name('index');
	Route::get('/admin/desa/kemasyarakatan/dusun-list', 'getDusun')->name('getDusun');
	Route::get('/admin/desa/kemasyarakatan/rw-list', 'getRW')->name('getRW');
	Route::get('/admin/desa/kemasyarakatan/rt-list', 'getRT')->name('getRT');
	Route::post('/admin/desa/kemasyarakatan/dusun', 'storeDusun')->name('dusun.store');
	Route::post('/admin/desa/kemasyarakatan/rw', 'storeRW')->name('rw.store');
	Route::post('/admin/desa/kemasyarakatan/rt', 'storeRT')->name('rt.store');
	
});

Route::bind('role', function ($id, $route) {
    return Hashids::decode($id)[0];
});

Route::controller(LogActivityController::class)->middleware(['admin.auth','admin.verified'])->name('log.')->group(function () {
	Route::get('/admin/log', 'index')->name('index');
});

Route::controller(RoleController::class)->middleware(['admin.auth','admin.verified'])->name('roles.')->group(function () {
	Route::get('/admin/roles', 'index')->name('index');
	Route::get('/admin/roles/get', 'get')->name('get');
	Route::get('/admin/roles/user-list', 'userWithout')->name('user-list');
	Route::get('/admin/roles/{role}/show', 'show')->name('show');
	Route::post('/admin/roles/{user}/update', 'update')->name('update');
	Route::post('/admin/roles/add-one', 'addOne')->name('add-one');
	Route::post('/admin/roles/add-many', 'addMany')->name('add-many');
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
	Route::get('/master/get-pekerjaan', 'getPekerjaan')->name('identitas.get-pekerjaan');
	Route::get('/master/get-pendidikan', 'getPendidikan')->name('identitas.get-pendidikan');
	Route::get('/master/get-hubungan', 'getHubungan')->name('ruta.get-hubungan');
});

Route::controller(WargaController::class)->middleware(['auth','verified'])->name('warga.')->group(function () {
	Route::get('/warga', 'index')->name('index');
	Route::get('/warga/get', 'getWargaHidup')->name('get-warga');
	Route::post('/warga', 'store')->name('store');
	Route::get('/warga/{warga}', 'show')->name('show');
});
Route::controller(KematianController::class)->middleware(['auth','verified'])->name('dinamika.kematian.')->group(function () {
	Route::get('/dinamika/kematian', 'index')->name('index');
	Route::post('/dinamika/kematian', 'store')->name('store');
	Route::put('/dinamika/kematian/{mati}/verif', 'verifikasi')->name('verifikasi');
});
Route::controller(KepindahanController::class)->middleware(['auth','verified'])->name('dinamika.kepindahan.')->group(function () {
	Route::get('/dinamika/kepindahan', 'index')->name('index');
	Route::post('/dinamika/kepindahan', 'store')->name('store');
	Route::put('/dinamika/kepindahan/{pindah}/verif', 'verifikasi')->name('verifikasi');
	
});

Route::controller(RutaController::class)->middleware(['auth','verified'])->name('ruta.')->group(function () {
	Route::get('/ruta', 'index')->name('index');
	Route::post('/ruta', 'store')->name('store');
	Route::get('/ruta/{ruta}', 'show')->name('show');
	Route::get('/ruta/{ruta}/edit', 'edit')->name('edit');
	Route::put('/ruta/{ruta}/update', 'update')->name('update');
	Route::delete('/ruta/{ruta}/delete', 'destroy')->name('delete');
	Route::delete('/ruta/anggota/{anggota_ruta}/delete', 'anggotaDestroy')->name('anggota.delete');
	Route::post('/ruta/{ruta}/anggota', 'storeAnggota')->name('anggota.store');
	Route::post('/ruta/{ruta}/kepala', 'updateKepala')->name('anggota.update-kepala');
	Route::post('/ruta/anggota', 'getAnggota')->name('anggota-get');
});

Route::controller(RutaController::class)->group(function () {
	Route::get('/get-warga-nonruta', 'getWargaNonRuta')->name('get-warga-nonruta');
});

require 'auth.php';
