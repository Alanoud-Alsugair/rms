<?php

namespace App\Http\Controllers;

use Gate;
use App\Tag;
use App\File;
use App\User;
use App\Group;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
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
        $user = User::find(Auth::id());
        $reports = DB::table('reports')->whereIn('group_id', $user->allowed_groups())->orderBy('id','desc')->get();

        return view('report.index')->with('reports',$reports);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('create-report')){
            return redirect()->route('index-report');
        }
        
        $groups = Group::all();
        $tags = Tag::all();
        return view('report.create')->with('groups',$groups)->with('tags',$tags);
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
            'desc' => 'required',
            'group' => 'required',
            'tag' => 'required'
        ]);
        

        $report = new Report();
        $report->name = $request->name;
        $report->desc = $request->desc;
        $report->group_id = $request->group;
        $report->created_by = Auth::id();// This will be logged user
        $report->save();

        
        $report->tags()->sync($request->tag); 

        return back()->with('success-store','Report Created Successfully :)');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::findOrFail($id);
        
        $user = User::find(Auth::id());

        if(!in_array($report->group_id,$user->allowed_groups()))
        {
            return redirect()->route('index-report');
        }

        return view('report.show')->with('report',$report);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('edit-report')){
            return redirect()->route('index-report');
        }
        
        $report = Report::findOrFail($id);

        $user = User::find(Auth::id());

        if(!in_array($report->group_id,$user->allowed_groups()))
        {
            return redirect()->route('index-report');
        }


        $groups = Group::all();
        $tags = Tag::all();
        $tags_arr = [];
        foreach($report->tags as $tag){
            $tags_arr[]=$tag->id;
        }
        return view('report.edit')->with('report',$report)->with('groups',$groups)->with('tags_arr',$tags_arr)->with('tags',$tags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'desc' => 'required',
            'group' => 'required',
            'tag' => 'required'
        ]);


        $report = Report::findOrFail($id);
        $report->name = $request->name;
        $report->desc = $request->desc;
        $report->group_id = $request->group;
        $report->created_by =  Auth::id(); // This will be logged user
        $report->save();

        $report->tags()->detach();
        $report->tags()->sync($request->tag); 

        return back()->with('success-update','Report Updated Successfully :)');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        foreach($report->files as $file)
        {
            if(file_exists(public_path("storage/files/$file->name")))
            {
                unlink(public_path("storage/files/$file->name"));
            }
        }

        $report->tags()->detach();

        $report->delete();

        return redirect()->route('index-report')->with('success-removed','Report Removed Successfully :)');
         
    }
}
