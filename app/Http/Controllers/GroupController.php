<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        return view('group.index')->with('groups',$groups);
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'group' => 'required'
        ]);

        $group = new Group();
        $group->name = $request->group;
        if($group->save())
        {
            return back()->with('success-store','Group Created Successfully :)');
        }
    }

    
    public function destroy(Group $group)
    {
        $group->delete();
        return back()->with('success-removed','Group Removed Successfully :)');
    }
}
