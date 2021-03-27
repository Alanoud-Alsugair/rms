@extends('layout.app')

@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-sm-6">
            <h1 class="p-3">Edit User {{ $user->name }}</h1>
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


            <form action="{{ route('update-user',$user->id) }}"
                  method="POST">
                @csrf

                <div class="form-group">
                    <label>User name : </label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email : </label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Password : </label>
                    <input type="password" name="password" value="{{ $user->password }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Role :</label>
                    <select class="form-control" name="role">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" <?php if($role->id == $user->role->id) { echo 'selected'; } ?>>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="">Groups :</label>
                <br>
                @foreach($groups as $group)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="group[]" value="{{ $group->id }}" 
                    <?php 

                        if(in_array($group->id,$groups_arr))
                        {
                            echo "checked";
                        }
                    ?>
                    >
                    <label class="form-check-label">{{ $group->name }}</label>
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
            <a href="{{ route('edit-user',$user->id) }}" class="btn btn-sm btn-warning" target="_blank">
             Edit User
            </a>
        </div>
        <div class="col-sm">
            <form action="{{ route('destroy-user',$user->id) }}" method="POST">
            @csrf
            <input type="submit" value="Remove User" class="btn btn-sm btn-danger">
            </form>
        </div>
        <div class="col-sm">
            <a href="{{ route('index-user') }}" class="btn btn-sm btn-secondary">
                Users Page 
            </a>
        </div>
    </div>
</div>
@endsection