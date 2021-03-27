@extends('layout.app')

@section('content')

<style>
.preview{
    text-decoration: underline;
    color: #00F;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(Session::has('success'))
                <h4 class="text-success">{{ session()->get('success') }}</h4>
            @else
                <h4 class="text-danger">{{ session()->get('faild') }}</h4>
            @endif

            @if(Session::has('success-removed'))
                <h4 class="text-success">{{ session()->get('success-removed') }}</h4>
            @endif

            
          

            @if($files->count() > 0)
            <table class="table table-bordered mt-4">
                <thead class="text-center">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">File</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($files as $file)
                        <tr>
                            <th scope="row">{{ $file->id }}</th>
                            <td>
                                <a href="{{ asset('storage/files/'.$file->name) }}" class="preview" target="_blank"> preview </a>
                            </td>
                            <td>
                            <form action="{{ route('destroy-report-file',$file->id) }}" method="POST">
                                @csrf
                                <input type="submit" value="Remove" class="btn btn-sm btn-danger">
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
                <h2 class="lead">No Report Files Yet !!</h2>
            @endif
        </div>
        <div class="col-sm-12 col-md-6">
            <form method="post" enctype="multipart/form-data" action="{{ route('store-report-file',$report_id) }}" style="padding-top:40px">
                @csrf 
                <div class="form-group">
                    <label>Choose a File</label>
                    <input type="file" name="file" class="form-control-file" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success col-md-3">Add File</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection



  