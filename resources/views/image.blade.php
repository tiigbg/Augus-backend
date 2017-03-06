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
                <div class="col-md-2">
                    <deletebutton
                        button="Delete image"
                        action="{{ route('images.destroy', $image->id) }}"
                        csrf_token="{{ csrf_token() }}" >
                    </deletebutton>
                </div>
            </div>
            @foreach($texts as $text)
                <p>
                <editabletext
                    value="{{ $text->text }}"
                    language="{{ $text->language }}"
                    id="{{ $text->id }}"
                    rows="20"
                    cols="100"
                    action="{{ route('texts.update', $text->id) }}"
                    csrf_token="{{ csrf_token() }}"
                    parent_type="{{ $text->parent_type }}"
                    method="PUT"
                    ></editabletext>
                <deletetextbutton
                    button="Delete text"
                    action="{{ route('texts.destroy', $text->id) }}"
                    csrf_token="{{ csrf_token() }}" 
                    method="DELETE">
                </deletetextbutton>
                </p>
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

            audios: {{ sizeof($audios)}}
            @foreach($audios as $audio)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            <a href="{{ route('audios.show', $audio->id) }}">
                                {{$audio->language}}: {{$audio->file}}
                            </a>
                        </p>
                        <audio width="320" height="240" controls>
                            <source src="{{ '../audioFile/'.$audio->id }}" type="audio/mp3">
                            Your browser does not support the audio tag.
                        </audio>
                        <deletebutton
                            button="Delete audio"
                            action="{{ route('audios.destroy', $audio->id) }}"
                            csrf_token="{{ csrf_token() }}" >
                        </deletebutton>
                    </div>
                </div>
            @endforeach

            <addfilebutton
                button="Add Audio"
                icon="glyphicon glyphicon-headphones"
                name="audio_file"
                language="sv"
                action="{{ route('audios.store') }}"
                method="POST"
                csrf_token="{{ csrf_token() }}"
                parent_id="{{ $image->id }}"
                parent_type="image"
                v-bind:language_enabled="true"></addfilebutton>
        </div>
    </div>
@endsection