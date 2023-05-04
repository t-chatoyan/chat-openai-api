@extends('layouts.app')

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header justify-content-between d-flex">
                    {{ __('Messages List') }}
                    <a class="btn btn-primary" href="{{route('export', $chat_id)}}">Export</a>
                </div>
                <div class="card-body overflow-auto" style="max-height: 80vh">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>
                        <ul class="list-unstyled">
                            @foreach ($messages as $message)
                                <li class="{{ $message['is_user'] ? 'd-flex justify-content-end' : 'chat-message' }}">
                                    <div class="d-flex overflow-hidden mb-3" style="width: 40%;">
                                        <div class="chat-message-wrapper flex-grow-1">
                                            <div class="chat-message-text p-3 border-success border-1 border bg-light shadow-lg p-1 mb-3 bg-white rounded">
                                                <strong>{{$message->is_user ? $message->chat->customer->name : 'Open Ai'}}</strong>
                                                <p class="mb-0">{{ $message['message'] }}</p>
                                            </div>
                                            <div class="text-muted">
                                                <small>{{ $message['time'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        {{$messages->onEachSide(5)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
