<?php

namespace App\Http\Controllers\User_Role;

use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Rules\ValidateKK;
use App\Rules\NIKExist;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Imports\UserImport;
use Illuminate\Support\Facades\DB;
use App\Notifications\PasswordSend;
use Illuminate\Support\Facades\Notification;


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
		$import = [
			'format' => '/import_format/user.xlsx',
			'csv' => '/import_format/user.csv',
			'link' => route('users.import'),
		   ];
		 return $dataTable->render('admin.users.index',compact(['title','import']));
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
	public function rwCount(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('users')
		->join('warga', 'warga.nik', '=', 'users.nik')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('is_active', 1)
		->where('rt.rw_id',$request['id'])
		->selectRaw('rt.name,count(users.nik) as count')
		->groupBy('rt.name')
		->get();
		}
		else{
			$chart = DB::table('users')
		->join('warga', 'warga.nik', '=', 'users.nik')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('rw.dusun_id',$request['dusun_id'])
		->where('is_active', 1)
		->selectRaw('rw.name,count(users.nik) as count')
		->groupBy('rw.name')
		->get();
		}
		$name = $chart->map->name->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
	public function dusunCount(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('users')
		->join('warga', 'warga.nik', '=', 'users.nik')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('is_active', 1)
		->where('rw.dusun_id',$request['id'])
		->selectRaw('rw.name,count(users.nik) as count')
		->groupBy('rw.name')
		->get();
		}
		else{
			$chart = DB::table('users')
		->join('warga', 'warga.nik', '=', 'users.nik')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->join('dusun', 'dusun.id', '=', 'rw.dusun_id')
		->where('is_active', 1)
		->selectRaw('dusun.name,count(users.nik) as count')
		->groupBy('dusun.name')
		->get();
		}
		$name = $chart->map->name->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
	public function validateKK(Request $request){
		$nik = $request['nik'];
		$validator = Validator::make($request->all(), [
            'no_kk' => ['required', 'string','size:16',new ValidateKK($nik)],
        ]);
 
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
	
		
	}
	public function validateNIK(Request $request){
		$validator = Validator::make($request->all(), [
            'nik' => ['required', 'string','size:16','unique:users,nik',new NIKExist],
        ]);
 
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
	
		
		
	}
	 public function store(UserRequest $request)
	{
		
		$validated = $request->validated();
		
		

		$validated['password'] = Hash::make($validated['password']);

		$user = User::create($validated);
		$user->assignRole('warga');

		$user->sendEmailVerificationNotification();
		Notification::send($user, new PasswordSend($request['password'],route('login')));

		return back()->withSuccess('Data pengguna berhasil ditambahkan');
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
		return view('admin.users.show', compact(['user','title']));
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
			'email' => ['required','string','email','unique:users,email,'. $user->id],
			'username' => ['required', 'string','unique:users,username,'. $user->id],
            
		]);
		$email = $user->email;
		

		$user->update($data);

		if($data['email']!=$email){
			$user->sendEmailVerificationNotification();
			$user->update(['email_verified_at' => NULL]);
		}

		return back()->withSuccess('Data berhasil diperbarui');
	}

	public function get(User $user)
    {
		return json_encode($user);
    }
	public function password(Request $request, User $user)
	{
		$data = $request->validate([
			'password' => ['required', 'string','confirmed',Password::min(8)->letters()->numbers()],
            
		]);
		$data['password'] = Hash::make($data['password']);
		$user->update($data);
		Notification::send($user, new PasswordSend($request['password'],route('login')));

		return back()->withSuccess('Password berhasil diperbarui');
	}

	public function status(Request $request, User $user)
	{
		$data['is_active'] = false;
		if(!$user->is_active){
			$data['is_active'] = true;
		}
		$user->update($data);

		return back()->withSuccess('Status pengguna '.$user->username.' berhasil diubah');
	}
	public function import(Request $request)
    {
        $this->validate($request, [
            'import' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('import');
        $import = new UserImport();
        $import->import($file);
        if(count($import->failures())>=1){
            return back()->withError('Import data user gagal : '.count($import->failures()).' data');
        }
        else{
            return back()->withSuccess('Import data user berhasil');
        }

        
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
