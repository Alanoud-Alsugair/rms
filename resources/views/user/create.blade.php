@extends('layout.app')

@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-sm-6">
            <h1 class="p-3">Create A New User</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::has('success-store'))
                <h4 class="text-success">{{ session()->get('success-store') }}</h4>
            @endif

            <form action="{{ route('store-user') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name : </label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Email : </label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Password : </label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Role :</label>
                    <select class="form-control" name="role">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <label for="">Group :</label>
                <br>
                @foreach($groups as $group)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="group[]" value="{{ $group->id }}">
                    <label class="form-check-label">{{ $group->name }}</label>
                </div>
                @endforeach
                <br>
                <input type="submit" value="Add" class="btn btn-primary mt-2">
            </form>
        </div>
    </div>
    <hr>
    <div class="row mt-3">
        <div class="col-sm-3">
        
        </div>
        <div class="col-sm-3">
            
        </div>
        <div class="col-sm-3">
            
        </div>
        <div class="col-sm-3">
            <a href="{{ route('index-user') }}" class="btn btn-sm btn-secondary">
                Users Page 
            </a>
        </div>
    </div>
</div>
@endsection