@extends('layout.app')

@section('content')

<style>
.preview{
    text-decoration: underline;
    color: #00F;
}
</style>

<div class="container py-4">
    <div class="row">
        <div class="col-sm">
        
        <h1 class="p-3 text-center">Report Details : </h1>
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        
                        <th scope="col">Report name</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Report Group</th>
                        <th scope="col">Report Tags</th>
                    </tr>
                </thead>
                <tbody class="text-center">
          
                    <tr>
                        
                        <td>{{ $report->name }}</td>
                        <td> {{  $report->user->name }} </td>
                        <td>
                            {{ $report->group->name }}
                        </td>
                        <td>
                        @if($report->tags->count() > 0)
                           @foreach($report->tags as $tag)
                                @if($loop->last)
                                    {{ $tag->name }}
                                @else
                                    {{ $tag->name }} ,
                                @endif
                           @endforeach
                        @else 
                            No Tags
                        @endif
                        </td>
                    </tr>
             
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <label for="">Report description :</label>
                <textarea  class="form-control" cols="10" rows="5" disabled>{{ $report->desc }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">

        
        <label for="">Report Files : </label><br>
        @if($report->files->count()==0)
            <h2 class="lead">There are no files related to this report</h2>
        @else
        <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">File Preview</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($report->files as $file)
                        <tr>   
                            <td>{{ $loop->index+1 }}</td>
                            <td> 
                                <a href="{{ asset('storage/files/'.$file->name) }}" class="preview" target="_blank"> preview </a>
                            </td>
                        </tr>
                
                        
                       
                    @endforeach
                </tbody>
            </table>
            @endif
        
            
      
        </div>
    </div>
    <hr>
    <div class="row mt-3">
    @can('manage-report-files')
        <div class="col-sm">        
            <a href="{{ route('index-report-file',$report->id) }}" class="btn btn-sm btn-primary">
                Manage Report Files
            </a>
        </div>
    @endcan

    @can('edit-report')
        <div class="col-sm">
            <a href="{{ route('edit-report',$report->id) }}" class="btn btn-sm btn-warning">
            Edit Report
            </a>
        </div>
    @endcan

    @can('delete-report')
        <div class="col-sm">
            <form action="{{ route('destroy-report',$report->id) }}" method="POST">
            @csrf
            <input type="submit" value="Remove Report" class="btn btn-sm btn-danger">
            </form>
        </div>
    @endcan
        <div class="col-sm">
            <a href="{{ route('index-report') }}" class="btn btn-sm btn-secondary">
                Reports Page 
            </a>
        </div>
    </div>
    
    

</div>

@endsection