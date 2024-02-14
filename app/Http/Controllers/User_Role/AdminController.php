<?php

namespace App\Http\Controllers\User_Role;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AdminDataTable;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminDataTable $dataTable)
    {
       $title = 'Manajemen Admin';
        return $dataTable->render('admin.admin.index',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
			'nama' => ['required','string'],
			'email' => ['required','string','email','unique:admin,email'],
			'username' => ['required', 'string','unique:admin,username'],
			'password' => ['required', 'string','confirmed',Password::min(8)->letters()->numbers()],
		]);
        $data['password'] = Hash::make($data['password']);

		$user = Admin::create($data);
		$user->assignRole('admin');

		$user->sendEmailVerificationNotification();

		return back()->withSuccess('Data admin berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    public function status(Request $request, Admin $user)
	{
		$data['status'] = 'nonaktif';
		if($user->status=='nonaktif'){
			$data['status'] = 'aktif';
		}
		$user->update($data);

		return back()->withSuccess('Status admin '.$user->username.' berhasil diubah');
	}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
