<?php

namespace App\Http\Controllers\User_Role;

use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\RT;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Arr;
use DataTables;
use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

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
        $users = User::role($role->name)->where('is_active',true)->paginate(10);
        $title = 'Role : '.$role->name;
        $allUsers = User::with('warga')->withoutRole($role)->get();
        
		return view('admin.roles.show', compact(['role','users','title','allUsers']));
    }
    public function userWithoutPemimpin(Request $request){
        $allUsers = User::with('warga')->withoutRole(['kepala desa','kepala dusun','ketua rw','ketua rt']);
        if($request['kode']==1){
            $allUsers = $allUsers->get();
        }
        else if($request['kode']==2){
            $rt = RT::whereHas("rw.dusun", function(Builder $builder) use($request) {
                $builder->where('name', '=', $request['name']);
            })->pluck('id');
            $allUsers = $allUsers->whereHas("warga", function(Builder $builder) use($request,$rt) {
                $builder->whereIn('rt_id',$rt );
            })->get();
        }
        else if($request['kode']==3){
            $rt = RT::whereHas("rw", function(Builder $builder) use($request) {
                $builder->where('name', '=', $request['name']);
            })->pluck('id');
            $allUsers = $allUsers->whereHas("warga", function(Builder $builder) use($request,$rt) {
                $builder->whereIn('rt_id',$rt );
            })->get();
        }
        else if($request['kode']==4){
            $rt = RT::where('name',$request['name'])->pluck('id');
            $allUsers = $allUsers->whereHas("warga", function(Builder $builder) use($request,$rt) {
                $builder->whereIn('rt_id',$rt );
            })->get();
        }
        foreach($allUsers as $item){
            echo "<option data-tokens='".$item->username.$item->warga->nama."' value='".$item->id."'>".$item->username.' | '.$item->warga->nama."</option>";
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
        if($role->name=='admin'){
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