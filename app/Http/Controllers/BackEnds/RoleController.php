<?php

namespace App\Http\Controllers\BackEnds;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use DB;
class RoleController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index(Request $request)
	{
		$roles = Role::orderBy('id','DESC')->paginate(5);
		return view('BackEnds.roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
	}
	public function create()
	{
		$permission = Permission::get();
		return view('BackEnds.roles.create',compact('permission'));
	}
	public function store(Request $request)
	{
		$this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();
        foreach ($request->input('permission') as $key => $value) {
        	$roles->attachPermission($value);
        }
         return redirect()->route('BackEnds.roles.index')
                        ->with('success','Role created successfully');
	}
	public function show($id)
	{
		$role = Role::find($id);
		$rolePermission = Permission::join("permission_role","permission_role.permission.id","=","permission.id")
		->where("permission_role.role_id",$id)
		->get();
		return view('BackEnds.roles.show',compact('role','rolePermissions'));
	}
	public function edit($id)
	{
		$role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("permission_role")->where("permission_role.role_id",$id)
            ->pluck('permission_role.permission_id','permission_role.permission_id');

        return view('BackEnds.roles.edit',compact('role','permission','rolePermissions'));
	}
	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        DB::table("permission_role")->where("permission_role.role_id",$id)
            ->delete();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }

        return redirect()->route('BackEnds.roles.index')
                        ->with('success','Role updated successfully');
    }
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('BackEnds.roles.index')
                        ->with('success','Role deleted successfully');
    }
}
