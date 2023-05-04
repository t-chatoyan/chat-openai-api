@extends('layouts.app')

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Customers List') }}
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{route('chats', $customer->id)}}">Open Chats List</a>
                                        </td>
                                    </tr>
                                </a>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
