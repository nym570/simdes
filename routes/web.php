<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\WilayahIndoController;
use App\Http\Controllers\MasterDesaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/admin', [AdminHomeController::class,'index'])->name('admin.home')->middleware(['admin.auth']);


Route::controller(UserController::class)->middleware('admin.auth')->name('users.')->group(function () {
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

Route::controller(DesaController::class)->middleware('admin.auth')->name('m.desa.')->group(function () {
	Route::get('/admin/desa', 'index')->name('index');
	Route::put('/admin/desa/{desa}/update', 'update')->name('update');
	Route::put('/admin/desa/{desa}/update-deskripsi', 'updateDesc')->name('deskripsi');
	
});
Route::controller(DesaController::class)->middleware('admin.auth')->name('m.lkd.')->group(function () {
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


Route::controller(RoleController::class)->middleware('admin.auth')->name('roles.')->group(function () {
	Route::get('/admin/roles', 'index')->name('index');
	Route::get('/admin/roles/get', 'get')->name('get');
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
	Route::get('/get-dusun', 'getDusun')->name('get-dusun');
	Route::get('/get-RW', 'getRW')->name('get-rw');
	Route::get('/get-RT', 'getRT')->name('get-rt');
});

require 'auth.php';
