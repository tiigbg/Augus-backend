@extends('layouts.app')

@section('sidemenu')
    @include('layouts.menu')
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($section->parent_id)
        <a href="{{ '/section/'.$section->parent_id }}">&lt; Back</a>
    @else
        <a href="{{ '/exhibitions/' }}">&lt; Exhibitions</a>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
            <div class="col-md-12">
                <deletebutton
                    button="Delete section"
                    icon="glyphicon glyphicon-trash"
                    action="{{ route('deleteSection') }}"
                    sectionid="{{ $section->id }}"
                    csrf_token="{{ csrf_token() }}" >
                </deletebutton>
            </div>
            </div>
            @foreach($titles as $title)
                <h1>{{ $title->language }}:{{ $title->text }}
                <deletetextbutton
                    button=""
                    icon="glyphicon glyphicon-trash"
                    action="{{ route('texts.destroy', $title->id) }}"
                    csrf_token="{{ csrf_token() }}" 
                    method="DELETE">
                </deletetextbutton>
                </h1>
            @endforeach
            @if (sizeof($section->titles)==0)
            <h1>
                (untitled)
            </h1>
            @endif
            <addtextbutton
                button="Add title"
                type="title"
                text=""
                rows="1"
                language="sv"
                parent_id="{{ $section->id }}"
                parent_type="section"
                action="{{ route('texts.store') }}"
                csrf_token="{{ csrf_token() }}" 
                method="POST"></addtextbutton>
        </div>

        <div class="panel-body">
            @foreach($texts as $text)
                <div>{{ $text->language }}:{{ $text->text }}</div>
                <deletetextbutton
                    button=""
                    icon="glyphicon glyphicon-trash"
                    action="{{ route('texts.destroy', $text->id) }}"
                    csrf_token="{{ csrf_token() }}" 
                    method="DELETE">
                </deletetextbutton>
            @endforeach
            <addtextbutton
                button="Add description"
                type="body"
                text=""
                rows="20"
                cols="100"
                language="sv"
                parent_id="{{ $section->id }}"
                parent_type="section"
                action="{{ route('texts.store') }}"
                csrf_token="{{ csrf_token() }}" 
                method="POST"></addtextbutton>
            
            <ul>
                @foreach($children as $child)
                        <div class="panel panel-default">
            				<div class="panel-body">
                                <a href="../section/{{ $child->id }}">
                                    @foreach($child->titles as $title)
                                        {{$title->language}}: {{$title->text}}<br/>
                                    @endforeach
                                    @if (sizeof($child->titles)==0)
                                        (untitled)
                                    @endif
                                </a>
                                <addtextbutton
                                    button="Add title"
                                    type="title"
                                    text=""
                                    language="sv"
                                    parent_id="{{ $child->id }}"
                                    parent_type="section"
                                    action="{{ route('texts.store') }}"
                                    csrf_token="{{ csrf_token() }}" 
                                    method="POST"></addtextbutton>
			                	<deletebutton
                                    button=""
                                    icon="glyphicon glyphicon-trash"
			                		action="{{ route('deleteSection') }}"
			                		sectionid="{{ $child->id }}"
			                		csrf_token="{{ csrf_token() }}" >
			            		</deletebutton>
			            	</div>
		            	</div>
                @endforeach
            </ul>  
    		<newsectionbutton
            	action="{{ route('newSection') }}"
        		parent_id="{{ $section->id }}"
        		csrf_token="{{ csrf_token() }}" >
    		</newsectionbutton>
            
            
            <addcolorbutton
                button="Set color"
                action="{{ route('addColor') }}"
                method="POST"
                color="{{ $section->color }}"
                parent_id="{{ $section->id }}"
                csrf_token="{{ csrf_token() }}"></addcolorbutton>
            <addfilebutton
                button="Add image"
                name="image_file"
                language="sv"
                action="{{ route('postimage') }}"
                method="POST"
                csrf_token="{{ csrf_token() }}"
                parent_id="{{ $section->id }}"></addfilebutton>

            <addfilebutton
                button="Add video"
                name="video_file"
                language="sv"
                action="{{ route('videos.store') }}"
                method="POST"
                csrf_token="{{ csrf_token() }}"
                parent_id="{{ $section->id }}"
                language_enabled="true"></addfilebutton>

            <addfilebutton
                button="Add signlanguage video"
                name="signlanguage_file"
                language="sv"
                action="{{ route('signlanguages.store') }}"
                method="POST"
                csrf_token="{{ csrf_token() }}"
                parent_id="{{ $section->id }}"
                language_enabled="true"></addfilebutton>

            <addfilebutton
                button="Add Audio"
                name="audio_file"
                language="sv"
                action="{{ route('audios.store') }}"
                method="POST"
                csrf_token="{{ csrf_token() }}"
                parent_id="{{ $section->id }}"
                language_enabled="true"></addfilebutton>
  
            <div class="row">
            @foreach($images as $image)
                <div class="col-xs-6 col-md-3">
                    <a href="{{ route('images.show', $image->id) }}" class="thumbnail">
                        <img src="{{ '../imageFile/'.$image->id }}">
                    </a>
                </div>
            @endforeach
            </div>

            signlanguages: {{ sizeof($signlanguages)}}
            @foreach($signlanguages as $signlanguage)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            <a href="{{ route('signlanguages.show', $signlanguage->id) }}">
                                {{$signlanguage->language}}: {{$signlanguage->file}}
                            </a>
                        </p>
                        <video width="320" height="240" controls>
                            <source src="{{ '../signlanguageFile/'.$signlanguage->id }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <deletebutton
                            button="Delete signlanguage"
                            action="{{ route('signlanguages.destroy', $signlanguage->id) }}"
                            csrf_token="{{ csrf_token() }}" >
                        </deletebutton>
                    </div>
                </div>
            @endforeach

            videos: {{ sizeof($videos)}}
            @foreach($videos as $video)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            <a href="{{ route('videos.show', $video->id) }}">
                                {{$video->language}}: {{$video->file}}
                            </a>
                        </p>
                        <video width="320" height="240" controls>
                            <source src="{{ '../videoFile/'.$video->id }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video> 
                        <deletebutton
                            button="Delete video"
                            action="{{ route('videos.destroy', $video->id) }}"
                            csrf_token="{{ csrf_token() }}" >
                        </deletebutton>
                    </div>
                </div>
            @endforeach

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
        </div>
    </div>
@endsection