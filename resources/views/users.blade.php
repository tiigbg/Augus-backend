@extends('layouts.app')

@section('sidemenu')
    @include('layouts.menu')
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Users
        </div>
        <div class="panel-body">
            @foreach($users as $user)
                <a href="/user/{{ $user->id }}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {{$user->name}}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection