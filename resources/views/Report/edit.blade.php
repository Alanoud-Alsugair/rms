@extends('layout.app')

@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-sm-6">
            <h1 class="p-3">Edit Report</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::has('success-update'))
                <h4 class="text-success">{{ session()->get('success-update') }}</h4>
            @endif
            <form action="{{ route('update-report',$report->id) }}"
                  method="POST"  
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Report name : </label>
                    <input type="text" name="name" value="{{ $report->name }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Report description :</label>
                    <textarea name="desc"  cols="30" rows="5" class="form-control">{{ $report->desc }}
                    </textarea>
                </div>
                <div class="form-group">
                    <label>Report group :</label>
                    <select class="form-control" name="group">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" <?php if($group->id == $report->group->id) { echo 'selected'; } ?>>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="">Report tags :</label>
                <br>
                @foreach($tags as $tag)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="tag[]" value="{{ $tag->id }}" 
                    <?php 

                        if(in_array($tag->id,$tags_arr))
                        {
                            echo "checked";
                        }
                    ?>
                    >
                    <label class="form-check-label">{{ $tag->name }}</label>
                </div>
                @endforeach
                <br>
                <input type="submit" value="Save" class="btn btn-success mt-2">
            </form>
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <div class="col-sm">
            <a href="{{ route('index-report-file',$report->id) }}" class="btn btn-sm btn-primary" target="_blank">
                Manage Report Files
            </a>
        </div>
      
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