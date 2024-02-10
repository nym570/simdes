<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	 public function index(UsersDataTable $dataTable)
	 {
		$title = 'Manajemen Pengguna';
		 return $dataTable->render('admin.users.index',compact('title'));
	 }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$user = new User;
		return view('users.create', compact('user'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserRequest $request)
	{
		$validated = $request->validated();

		$validated['password'] = Hash::make($validated['password']);

		$user = User::create($validated);

		$user->sendEmailVerificationNotification();

		return to_route('users.index')->withSuccess('Data pengguna berhasil ditambahkan');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(User $user)
	{
		$title = 'Profil '.$user->username;
		$roles =  Role::get()->groupBy('category');
		return view('admin.users.show', compact(['user','title','roles']));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(User $user)
	{
		return view('users.edit', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		$data = $request->validate([
			'nama' => ['required','string'],
			'email' => ['required','string','email','unique:users,email,'. $user->id],
			'username' => ['required', 'string','unique:users,username,'. $user->id],
            'nik' => ['required', 'string','size:16'],
            'no_kk' => ['required', 'string','size:16'],
            'no_telp' => ['required', 'string','regex:/62[0-9]+$/u'],
		]);
		$email = $user->email;
		

		$user->update($data);

		if($data['email']!=$email){
			$user->sendEmailVerificationNotification();
			$user->update(['email_verified_at' => NULL]);
		}

		return to_route('users.show',$user)->withSuccess('Data berhasil diperbarui');
	}

	public function status(Request $request, User $user)
	{
		$data['status'] = 'nonaktif';
		if($user->status=='nonaktif'){
			$data['status'] = 'aktif';
		}
		$user->update($data);

		return back()->withSuccess('Status pengguna '.$user->username.' berhasil diubah');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function role(Request $request,User $user)
	{
		$role = $request->only('roles');
		$user->syncRoles($role);
		return back()->withSuccess('Role berhasil diubah');
	}
	
	 public function deleteRole(Request $request,User $user)
	{
		$role = $request->all()['role'];
		$user->removeRole($role);
		return back()->withSuccess('User berhasil dihapus dari role');
	}
	
	 public function delete(User $user)
	{
		$user->delete();
		return to_route('users.index')->withSuccess('Pengguna berhasil dihapus');
	}
}
