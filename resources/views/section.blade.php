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
                language=""
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
                language=""
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
                                    language=""
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
            
            <addfilebutton
                button="Add image"
                name="image_file"
                action="{{ route('postimage') }}"
                method="POST"
                csrf_token="{{ csrf_token() }}"
                parent_id="{{ $section->id }}"></addfilebutton>
  
            <div class="row">
            @foreach($images as $image)
                <div class="col-xs-6 col-md-3">
                    <a href="{{ route('images.show', $image->id) }}" class="thumbnail">
                        <img src="/images/{{$image->file}}">
                    </a>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection