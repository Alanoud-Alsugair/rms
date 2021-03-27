@extends('layout.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-sm p-4 text-center">
        <h2>Groups Management</h2>
        <small class="text-danger"><span style="text-decoration:underline;font-weight:bold">Note:</span> When you delete a group , then all the reports related to this group will be also deleted</small>
        </div>
    </div>
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
            
            @if(Session::has('success-store'))
                <h4 class="text-success">{{ session()->get('success-store') }}</h4>
            @endif

            @if(Session::has('success-removed'))
                <h4 class="text-success">{{ session()->get('success-removed') }}</h4>
            @endif

            
          

            @if($groups->count() > 0)
            <table class="table table-bordered mt-4">
                <thead class="text-center">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Group</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($groups as $group)
                        <tr>
                            <th scope="row">{{ $group->id }}</th>
                            <td>
                               {{ $group->name }}
                            </td>
                            <td>
                            <form action="{{ route('destroy-group',$group->id) }}" method="POST">
                                @csrf
                                <input type="submit" value="Remove" class="btn btn-sm btn-danger">
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else 
                <h2 class="lead">No Groups Yet !!</h2>
            @endif
        </div>
        <div class="col-sm-12 col-md-6">
            <form method="post"  action="{{ route('store-group') }}" style="padding-top:40px">
                @csrf 
                <div class="form-group">
                    <label>Group name :</label>
                    <input type="text" name="group" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success col-md-3">Add Group</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection



  