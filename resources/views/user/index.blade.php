@extends('layout.app')


@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-sm">
        @isset($users)
        <h1 class="p-3 text-center">Users Management</h1>
        <a href="{{ route('create-user') }}" class="btn btn-primary my-3">Add User</a>
        @if(Session::has('success-removed'))
            <h4 class="text-success">{{ session()->get('success-removed') }}</h4>
        @endif

            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <a href="{{ route('edit-user',$user->id) }}" class="btn btn-sm btn-warning" target="_blank">
                                Edit
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('destroy-user',$user->id) }}" method="POST">
                                @csrf
                                <input type="submit" value="Remove" class="btn btn-sm btn-danger">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else 
        <h3>Not Users Yet</h3>
        @endisset
        </div>
    </div>
</div>
@endsection