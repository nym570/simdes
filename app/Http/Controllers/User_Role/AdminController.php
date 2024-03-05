<?php

namespace App\Http\Controllers\User_Role;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AdminDataTable;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Imports\AdminImport;
use App\Notifications\PasswordSend;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminDataTable $dataTable)
    {
       $title = 'Manajemen Admin';
       $import = [
        'format' => '/import_format/admin.xlsx',
        'link' => route('admin-list.import'),
       ];
        return $dataTable->render('admin.admin.index',compact(['title','import']));
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

        Notification::send($user, new PasswordSend($request['password'],route('admin.login')));
		$user->sendEmailVerificationNotification();

		return back()->withSuccess('Data admin berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'import' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('import');
        $import = new AdminImport();
        $import->import($file);
        if(count($import->failures())>=1){
            return back()->withError('Import data admin gagal : '.count($import->failures()).' data');
        }
        else{
            return back()->withSuccess('Import data admin berhasil');
        }

        
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
        $validasi = [
            'username' => ['required', 'string','unique:admin,username,'.$admin->id],
            'nama' => ['required','string'],
			'email' => ['required','string','email','unique:admin,email,'.$admin->id],
        ];
        
        $data = Validator::make($request->all(), $validasi);
        if ($data->fails()) {
            return back()->withError('Update Admin gagal');
        }
        $data = $data->valid();
        $email = $admin->email;
		

		$admin->update($data);

		if($data['email']!=$email){
			$admin->sendEmailVerificationNotification();
			$admin->update(['email_verified_at' => NULL]);
		}
        return back()->withSuccess('Data admin berhasil diubah');
    }

    public function get(Admin $admin)
    {
		return json_encode($admin);
    }

    public function resetPass(Request $request, Admin $admin)
    {
       $pass = Validator::make($request->all(), [
			'password' => ['required', 'string','confirmed',Password::min(8)->letters()->numbers()],
		]);
        if ($pass->fails()) {
            return back()->withError('Update password gagal');
        }
        $data = $pass->valid();
        $data['password'] = Hash::make($data['password']);
        $admin->update($data);
        Notification::send($admin, new PasswordSend($request['password'],route('admin.login')));
        return back()->withSuccess('Password admin berhasil diubah');
    }

    public function status(Request $request, Admin $user)
	{
		$data['is_active'] = false;
		if(!$user->is_active){
			$data['is_active'] = true;
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
