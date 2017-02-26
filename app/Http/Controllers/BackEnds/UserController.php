<?php
namespace App\Http\Controllers\BackEnds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use DB;
use Hash;

class UserController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index(Request $request)
    {
    	$data = User::orderBy('id','DESC')->paginate(5);
    	return view('BackEnds.users.index',compact('data'))
    	->with('i',($request->input('page',1) - 1) * 5);
    }
    public function create()
    {
    	$roles = Role::pluck('display_name','id');
    	return view('BackEnds.users.create',compact('roles'));
    }
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
    		]);
    	$input = $request->all();
    	$input['password'] = Hash::make($input['password']);

    	$user = User::create($input);
    	foreach ($request->input('roles') as $key => $value) {
    		$user->attachRole($value);
    	}

    	return redirect()->route('user.index')
    	->with('success','User created successfully');
    }
    public function edit($id)
    {
    	$user= User::find($id);
    	$roles = Role::pluck('display_name','id');
    	$userRole = $user->roles->pluck('id','id')->toArray();

    	return view('BackEnds.users.edit',compact('user','roles','userRole'));
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('BackEnds.users.show',compact('user'));
    }

    public function update(Request $request,$id)
    {
    	$this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
        	$input['password'] = Hash::make($input['password']);
        }
        else{
        	$input = array_except($input,array('password')); 
        }

        $user = USer::find($id);
        $user->update($input);
        DB::table('role_user')->where('user_id',$id)->delete();

        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');

    }
    public function destroy($id)
    {
    	User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
