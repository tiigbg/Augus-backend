@extends('layouts.app')

@section('sidemenu')
    @include('layouts.menu')
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            @foreach($texts as $text)
                <h1>{{ $text->language }}:{{ $text->text }}</h1>
                <deletetextbutton
                    button="Delete text"
                    action="{{ route('texts.destroy', $text->id) }}"
                    csrf_token="{{ csrf_token() }}" 
                    method="DELETE">
                </deletetextbutton>
            @endforeach
            @if (sizeof($image->texts)==0)
            <h1>
                (untitled)
            </h1>
            @endif
            <addtextbutton
                button="Add text"
                type="body"
                text=""
                language=""
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
        <img src="/images/{{$image->file}}">
    </div>
@endsection