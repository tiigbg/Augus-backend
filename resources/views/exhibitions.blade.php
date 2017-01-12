@extends('layouts.app')

@section('sidemenu')
    @include('layouts.menu')
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Exhibitions
        </div>
        <div class="panel-body">
            @foreach($exhibitions as $exhibition)
                <a href="/section/{{ $exhibition->id }}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @foreach($exhibition->titles as $title)
                                {{ $title->language }}:{{ $title->text }}<br/>
                            @endforeach
                            @if (sizeof($exhibition->titles)==0)
                            <div >
                                (untitled)
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
            <div class="panel panel-default panel-striped">
                <div class="panel-body">
                    <form action="{{ route('newSection') }}" method="POST">
                        <input type="submit" name="submit" value="Add new exhibition" class="btn btn-success"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection