<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;

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
    	// TODO delete all linked content
    	$section->delete();
    	return redirect('exhibitions');
    }

    public function getAllExhibitions(Request $request) {
    	return Section::whereNull('parent_id')->with('titles')->get();
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