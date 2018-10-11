@extends('layouts.app')

@section('sidemenu')
    @include('layouts.menu')
@endsection

@section('content')

    <a href="{{ '/section/'.$image->parent_id }}">&lt; Back</a>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ '../triggerMarkerFile/'.$image->id }}" class="thumbnail">
                        <img src="{{ '../triggerMarkerFile/'.$image->id }}" >
                    </a>
                </div>
                <div class="col-md-2">
                    <deletebutton
                        button="Delete image"
                        action="{{ route('triggerMarkers.destroy', $image->id) }}"
                        csrf_token="{{ csrf_token() }}" >
                    </deletebutton>
                </div>
            </div>
        </div>
    </div>
@endsection