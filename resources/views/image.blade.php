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
                    <a href="{{ '../imageFile/'.$image->id }}" class="thumbnail">
                        <img src="{{ '../imageFile/'.$image->id }}" >
                    </a>
                </div>
            </div>
            @foreach($texts as $text)
                <p>{{ $text->language }}:{{ $text->text }}</p>
                <deletetextbutton
                    button="Delete text"
                    action="{{ route('texts.destroy', $text->id) }}"
                    csrf_token="{{ csrf_token() }}" 
                    method="DELETE">
                </deletetextbutton>
            @endforeach
            @if (sizeof($image->texts)==0)
            <p>
                (no description)
            </p>
            @endif
            <addtextbutton
                button="Add description"
                type="body"
                text=""
                language="sv"
                parent_id="{{ $image->id }}"
                parent_type="image"
                action="{{ route('texts.store') }}"
                csrf_token="{{ csrf_token() }}" 
                method="POST"></addtextbutton>

            <deletebutton
                button="Delete image"
                action="{{ route('images.destroy', $image->id) }}"
                csrf_token="{{ csrf_token() }}" >
            </deletebutton>
        </div>
    </div>
@endsection