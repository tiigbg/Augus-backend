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
        </div>
    </div>
@endsection