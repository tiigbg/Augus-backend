<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Text;
use App\Icon;
use App\Image;
use App\Audio;
use App\Video;
use App\Signlanguage;
use App\Mesh;
use App\TriggerMarker;

class SectionController extends Controller
{
    public function store(Request $request)
    {
        $section = new Section;

        $section->parent_id = $request->parent_id;
        $section->visibility = "hidden";
        $section->order = $this->getNewOrder($request->parent_id);

        $section->save();
        return back();
    }

    public function update(Request $request) {
    	$section = Section::find($request->id);

    	if(isset($request->parent_id)) {
    		$section->parent_id = $request->parent_id;
    	}
    	if(isset($request->order)) {
            $section->order = $request->order;
        }
        if(isset($request->visibility)) {
    		$section->visibility = $request->visibility;
    	}
    	$section->save();
        return back();
    }

    public function delete(Request $request) {
		$children = $this->getChildren($request, $request->id);
    	foreach ($children as $child) {
    		$new_request = clone $request;
    		$new_request->id = $child->id;
    		$this->delete($new_request);
    	}
    	$section = Section::find($request->id);
        $icon = $section->sectionIcon()->get();
        $titles = $section->titles()->get();
        $texts = $section->texts()->get();
        $images = $section->images()->get();
        $audios = $section->audios()->get();
        $videos = $section->videos()->get();
    	$signlanguages = $section->signlanguages()->get();
    	$meshes = $section->meshes()->get();
    	$triggerMarkers = $section->triggerMarkers()->get();

        if($icon != NULL && isset($icon->id))
        {
            App('App\Http\Controllers\IconController')->destroy($icon->id);
        }

        foreach ($titles as $child) {
            App('App\Http\Controllers\TextController')->destroy($child->id);
        }
        foreach ($texts as $child) {
            App('App\Http\Controllers\TextController')->destroy($child->id);
        }
        foreach ($images as $child) {
            App('App\Http\Controllers\ImageController')->destroy($child->id);
        }
        foreach ($videos as $child) {
            App('App\Http\Controllers\VideoController')->destroy($child->id);
        }
        foreach ($audios as $child) {
            App('AtriggerMarkersollers\AudioController')->destroy($child->id);
        }
        foreach ($signlanguages as $child) {
            App('App\Http\Controllers\SignlanguageController')->destroy($child->id);
        }
        foreach ($meshes as $child) {
            App('App\Http\Controllers\MeshController')->destroy($child->id);
        }
        foreach ($triggerMarkers as $child) {
            App('App\Http\Controllers\TriggerMarkerController')->destroy($child->id);
        }

        $parent_id = $section->parent_id;
    	$section->delete();
        if($parent_id !== null)
            return redirect('/section/'.$parent_id)->with('success','Section deleted.');
    	return redirect('exhibitions');
    }

    public function getAllExhibitions(Request $request) {
        return array('exhibitions' => Section::whereNull('parent_id')->with('titles')->get());
    }

    public function getAllData(Request $request) {
        return array(
            'nodes' => Section::all(),
            'texts' => Text::all(),
            'icons' => Icon::all(),
            'images' => Image::all(),
            'audio' => Audio::all(),
            'video' => Video::all(),
            'signlanguages' => Signlanguage::all(),
            'meshes' => Mesh::all(),
            'triggerMarkers' => TriggerMarker::all(),
            );
    }

    public function getChildren(Request $request, $parent_id) {
    	return Section::where('parent_id','=', $parent_id)->get();
    }

    public function getNewOrder($parent_id = Null)
    {
    	if(is_null($parent_id))
    	{
			return Section::whereNull('parent_id')->max('order') + 1;
    	}
    	else
    	{
    		return Section::where('id','=', $parent_id)->first()->children()->max('order') + 1;
    	}
    }

    public function addColors(Request $request) {
        if(isset($request->parent_id)) {
            $section = Section::find($request->parent_id);
            if(isset($request->dark_color) && isset($request->light_color)) {
                $section->dark_color = $request->dark_color;
                $section->light_color = $request->light_color;
                $section->save();
            }
        }
        return back();
    }
}