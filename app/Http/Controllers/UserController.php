<?php

namespace App\Http\Controllers;

use App\Group;
use App\Role;
use App\Tag;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->sortByDesc("id");
        return view('user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(Gate::denies('create-user')){
        //     return redirect()->route('index-user');
        // }

        $roles = Role::all();
        $groups = Group::all();

        return view('user.create')->with([
            'roles' => $roles,
            'groups' => $groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'group' => 'required',
            'role' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;

        $user->save();
        
        $user->groups()->sync($request->group);

        return back()->with('success-store','User Created Successfully :)');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // if(Gate::denies('show-user')){
        //     return redirect()->route('index-user');
        // }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // if(Gate::denies('edit-user')){
        //     return redirect()->route('index-user');
        // }
        
        $roles = Role::all();
        $groups = Group::all();
        $groups_arr = [];
        foreach($user->groups as $group){
            $groups_arr[]=$group->id;
        }

        return view('user.edit')->with([
            'user' => $user ,
            'roles' => $roles ,
            'groups' => $groups,
            'groups_arr' => $groups_arr
        ]);
       
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
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'group' => 'required',
            'role' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;
        $user->save();
        
        $user->groups()->detach();
        $user->groups()->sync($request->group);

        return back()->with('success-update','User Updated Successfully :)');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // if(Gate::denies('destroy-user')){
        //     return redirect()->route('index-user');
        // }

        $user->delete();
        $user->groups()->detach();
        return redirect()->route('index-user')->with('success-removed','User Removed Successfully :)');
    }
}
