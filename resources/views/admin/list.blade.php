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
                        <a href="/admins/add">
                            <button class="btn btn-primary">
                                Add Admin
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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
                                            <a href="{{route('admins.update', $admin->id) }}">
                                                <button class="btn btn-success mx-2">Edit</button>
                                            </a>
                                            <form class="d-inline" action="{{ route('admins.destroy', $admin->id) }}" method="POST">
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
                        {{$admins->onEachSide(5)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
