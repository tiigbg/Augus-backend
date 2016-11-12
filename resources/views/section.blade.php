@extends('layouts.app')

@section('sidemenu')
    @include('layouts.menu')
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            @foreach($titles as $title)
                <h1>{{ $title->language }}:{{ $title->text }}</h1>
                <deletetextbutton
                    button="Delete title"
                    action="{{ route('texts.destroy', $title->id) }}"
                    csrf_token="{{ csrf_token() }}" 
                    method="DELETE">
                </deletetextbutton>
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

        	<deletebutton
                button="Delete section"
        		action="{{ route('deleteSection') }}"
        		sectionid="{{ $section->id }}"
        		csrf_token="{{ csrf_token() }}" >
    		</deletebutton>
        </div>

        <div class="panel-body">
            @foreach($texts as $text)
                <div>{{ $text->language }}:{{ $text->text }}</div>
                <deletetextbutton
                    button="Delete text"
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
            <img src="/images/{{ Session::get('image') }}">
            @endif

            {!! Form::open(array('route' => 'postimage','files'=>true)) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::file('image_file', array('class' => 'form-control')) !!}
                        <input type="hidden" name="parent_id" value="{{ $section->id }}">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            {!! Form::close() !!}

  
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