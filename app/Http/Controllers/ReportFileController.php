<?php

namespace App\Http\Controllers;

use Gate;
use App\File;
use App\User;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportFileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        if(Gate::denies('manage-report-files')){
            return redirect()->route('index-report');
        }
        

        $report = Report::findOrFail($id);

        $user = User::find(Auth::id());

        if(!in_array($report->group_id,$user->allowed_groups()))
        {
            return redirect()->route('index-report');
        }
        
        $files = $report->files;
      
        return view('report-file.index')->with('report_id',$id)->with('files',$files);
    }

    public function store(Request $request , $id)
    {
        $request->validate([
            'file' => 'mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        $fileName = '_file'.time().rand(0, 10000).'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('storage/files'), $fileName);

        $file = new File();
        $file->report_id = $id;
        $file->name = $fileName;

        if($file->save())
        {
            return back()->with('success','File added successfully :)'); 
        }
        return back()->with('faild','File added faild :('); 

    }
    public function destroy($id)
    {
        $file = File::find($id);
        $file->delete();
        if(file_exists(public_path("storage/files/$file->name"))){
            unlink(public_path("storage/files/$file->name"));
        }
        return back()->with('success-removed','File Removed Successfully :)');
    }
}
