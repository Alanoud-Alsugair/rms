<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
        
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reports = null;
        return view('search.index')->with('reports',$reports);
    }

    public function search(Request $request)
    {
        
        $request->validate([
            'search' => 'required',
            'search_by' => 'required'
        ]);

        $search_by = $request->search_by;
        $search = $request->search;
        switch($search_by)
        {
            
            case 'report_name':
                
                $user = User::find(Auth::id());
                $reports = DB::table('reports')->whereIn('group_id', $user->allowed_groups())->where('name', 'LIKE', "%$search%")->orderBy('id','desc')->get();
                return view('search.index')->with('reports',$reports);

            break;

            case 'content':

                $user = User::find(Auth::id());
                $reports = DB::table('reports')->whereIn('group_id', $user->allowed_groups())->where('desc', 'LIKE', "%$search%")->orderBy('id','desc')->get();
                return view('search.index')->with('reports',$reports);

            break;

            case 'tag':
                
                $user = User::find(Auth::id());
                
                $user_groups_arr = $user->allowed_groups();
                $user_groups ='(';
                for( $i = 0 ;  $i < count($user_groups_arr); $i++ )
                {
                    if($i == count($user_groups_arr)-1)
                    {
                        $user_groups.= $user_groups_arr[$i].')';
                    }
                    else
                    {
                        $user_groups.=$user_groups_arr[$i].',';
                    }   
                }

                $reports = DB::select("SELECT * FROM reports WHERE ( id IN (SELECT DISTINCT report_id FROM report_tag WHERE tag_id = (SELECT id FROM tags WHERE name = '$search')) ) AND (group_id IN $user_groups) ORDER BY id desc");

                return view('search.index')->with('reports',$reports);

            break;

            case 'group':
            
                $user = User::find(Auth::id());
                
                $user_groups_arr = $user->allowed_groups();
                $user_groups ='(';
                for( $i = 0 ;  $i < count($user_groups_arr); $i++ )
                {
                    if($i == count($user_groups_arr)-1)
                    {
                        $user_groups.= $user_groups_arr[$i].')';
                    }
                    else
                    {
                        $user_groups.=$user_groups_arr[$i].',';
                    }   
                }

                $reports = DB::select("SELECT * FROM `reports` WHERE (group_id = (SELECT id FROM groups WHERE name='$search')) AND (group_id IN $user_groups) ORDER BY id desc");

                return view('search.index')->with('reports',$reports);

            break;

            case 'uploader':
                $users = User::where('name', '=', $search)->get();
                $uploaders = [];

                foreach($users as $user)
                {
                    $uploaders[] = $user->id;
                }

                $user = User::find(Auth::id());
                $reports = DB::table('reports')->whereIn('group_id', $user->allowed_groups())->whereIn('created_by', $uploaders)->orderBy('id','desc')->get();
                return view('search.index')->with('reports',$reports);
            break;
        }
    }
}
