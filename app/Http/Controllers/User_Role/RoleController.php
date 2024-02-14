<?php

namespace App\Http\Controllers\User_Role;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Arr;
use DataTables;
use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */


    public function index(RolesDataTable $dataTable)
    {

        $title = 'Manajemen Role';
		 return $dataTable->render('admin.roles.index',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        
        $temp =[];
        $role = Role::create(['name' => $request->name,'category'=>$request->category]);
        $permissions = Permission::whereIn('id', $request->permission)->get('name')->toArray();
        $role->syncPermissions($permissions); 
        return redirect()->route('roles.index')
                ->withSuccess('Role baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $users = User::role($role->name)->where('status','aktif')->paginate(10);
        $title = 'Role : '.$role->name;
        
		return view('admin.roles.show', compact(['role','users','title']));
    }
    public function userWithout(Request $request){
        $id = $request->only('id_role');
        $role = Role::where('id',$id)->first();
        $category = Role::where('category',$role->category)->where('category','!=','warga')->where('guard_name','web')->pluck('name')->toArray();
        $allUsers = User::with('warga')->withoutRole($category)->get();
        foreach($allUsers as $item){
            echo "<option data-tokens='".$item->username."' value='".$item->username."'>".$item->username.' | '.$item->warga->nama."</option>";
        }
        
    }
    public function get(Request $request)
    {
        $id = $request->only('id_role');
        $role = Role::where('id',$id)->first();
        $user = User::role($role->name)->first();
        $url = route('roles.add-one',$user);
        if(!is_null($user)){
            $url = route('roles.update',$user);
        }
        
        $data = [
            'role' => $role,
            'user' => $user,
            'link' => $url,
           
        ];
		return json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // if($role->name=='Super Admin'){
        //     abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        // }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)
            ->pluck('permission_id')
            ->all();
        return view('management.roles.edit', [
            'role' => $role,
            'permissions' => Permission::orderBy('category')->get()->groupBy('category'),
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $data = $request->all();
		$user->removeRole($data['role']);

        $new_user = User::where('username',$data['user']) -> first();

        $new_user->assignRole($data['role']);
        return back()->withSuccess('Role berhasil diperbaharui.');
    }

    public function addOne(Request $request)
    {        
        $data = $request->all();
        $user = User::where('username',$data['user']) -> first();
        $user->assignRole($data['role']);
        return back()->withSuccess('Role berhasil diperbaharui.');
    }

    public function addMany(Request $request)
    {        
        $data = $request->all();
        
        $users = User::whereIn('username',$data['users'])->get();
        foreach($users as $user) {
            $user->assignRole($data['role']);
        }
        return back()->withSuccess('Role berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('roles.index')
                ->withSuccess('Role berhasil dihapus.');
    }
}