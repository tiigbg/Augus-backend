<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Text;
use App\Image;
use App\Audio;
use App\Video;
use App\Signlanguage;

class SectionController extends Controller
{
    public function store(Request $request)
    {
        $section = new Section;

        $section->parent_id = $request->parent_id;
        $section->order = $this->getNewOrder();

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
        $titles = $section->titles()->get();
        $texts = $section->texts()->get();
        $images = $section->images()->get();
        $audios = $section->audios()->get();
        $videos = $section->videos()->get();
    	$signlanguages = $section->signlanguages()->get();

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
            App('App\Http\Controllers\AudioController')->destroy($child->id);
        }
        foreach ($signlanguages as $child) {
            App('App\Http\Controllers\SignlanguageController')->destroy($child->id);
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
            'images' => Image::all(),
            'audio' => Audio::all(),
            'video' => Video::all(),
            'signlanguages' => Signlanguage::all(),
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
    		return Section::where('id','=', $parent_id)->max('order') + 1;
    	}
    }
}