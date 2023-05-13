@extends('layouts.app')

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-sm-between">
                        <span>
                            {{ __('Admins List') }}
                        </span>
                        <a href="{{route('admin.create') }}">
                            <button class="btn btn-primary">
                                Add Admin
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Settings</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($admins))
                                @foreach($admins as $admin)
                                    <tr>
                                        <td scope="col">{{$admin->id}}</td>
                                        <td scope="col">{{$admin->name}}</td>
                                        <td scope="col">{{$admin->email}}</td>
                                        <td scope="col">{{$admin->created_at}}</td>
                                        <td scope="col">
                                            <a href="{{route('admin.edit', $admin->id) }}">
                                                <button class="btn btn-success mx-2">Edit</button>
                                            </a>
                                            <form onsubmit="return confirm('Do you want to delete this admin?');" class="d-inline" action="{{ route('admin.destroy', $admin->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{$admins->onEachSide(15)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
