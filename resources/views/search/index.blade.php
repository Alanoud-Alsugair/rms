@extends('layout.app')


@section('content')

<div class="container py-4">
    <div class="row">
    
        <div class="col-sm-6">
            <h1 class="p-3 text-center">Look For Reports</h1>
            <hr>
            <form action="{{ route('search') }}" method="GET">
                <div class="form-group">
                    <label>Search By :</label>
                    <select class="form-control" name="search_by">
                            <option value="report_name">report name</option>  
                            <option value="content">content</option>  
                            <option value="tag">tag</option>  
                            <option value="group">group</option>  
                            <option value="uploader">uploader</option>  
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Type something to search :</label>
                    <input type="text" name="search" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Search" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm">
        @isset($reports)
            @if(count($reports) > 0)
            
        
        

            @if(Session::has('success-removed'))
                <h4 class="text-success">{{ session()->get('success-removed') }}</h4>
            @endif

                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Details</th>
                            @can('edit-report')
                            <th scope="col">Edit</th>
                            @endcan
                            @can('delete-report')
                            <th scope="col">Remove</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($reports as $report)
                        <tr>
                            <th scope="row">{{ $report->id }}</th>
                            <td>{{ $report->name }}</td>
                            <td>
                                <a href="{{ route('show-report',$report->id) }}" class="btn btn-sm btn-primary" target="_blank">
                                    View
                                </a>
                            </td>
                            @can('edit-report')
                            <td>
                                <a href="{{ route('edit-report',$report->id) }}" class="btn btn-sm btn-warning" target="_blank">
                                    Edit
                                </a>
                            </td>
                            @endcan
                            @can('delete-report')
                            <td>
                                <form action="{{ route('destroy-report',$report->id) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="Remove" class="btn btn-sm btn-danger">
                                </form>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else 
            <h3>No Reports</h3>
            @endif
        @endisset
        </div>
    </div>
</div>
@endsection