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

                    <div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Chat Name</th>
                                <th scope="col">Created At</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($chats as $chat)
                                <tr>
                                    <td>
                                        {{ $chat->id }}
                                    </td>
                                    <td>{{ $chat->customer->name }}</td>
                                    <td>{{ $chat->name }}</td>
                                    <td>{{ $chat->customer->created_at }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('messages', $chat->id)}}">Open Messages</a>
                                    </td>
                                </tr>
                                </a>
                            @endforeach
                            </tbody>
                        </table>
                        {{$chats->onEachSide(5)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
