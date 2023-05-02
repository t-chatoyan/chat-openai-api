@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card d-flex">
                <div class="card-header">
                    {{ __('Dashboard') }}
                </div>
                <div class="d-flex">
                    <div class="w-25">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-center"><a href="{{ route('menu1') }}">menu1</a></li>
                            <li class="list-group-item d-flex justify-content-center"><a href="{{ route('menu1') }}">menu1</a></li>
                            <li class="list-group-item d-flex justify-content-center"><a href="{{ route('menu1') }}">menu1</a></li>
                            <li class="list-group-item d-flex justify-content-center"><a href="{{ route('menu1') }}">menu1</a></li>
                        </ul>
                    </div>
                    <div>
                        dfsdgdffd
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
