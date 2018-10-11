<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\TriggerMarker;
use Storage;

class TriggerMarkerController extends Controller
{

    public function triggerMarkerFile($id)
    {
        $triggermarker = TriggerMarker::find($id);
        $contents = Storage::disk('local')->get('uploads/triggermarkers/'.$triggermarker->file);
        $response = Response($contents);
        $response->header('Content-Type', 'image');
        return $response;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = TriggerMarker::find($id);
        $data = [
            'image' => $image
         ];
        return view('triggermarker', $data);
    }

    /**
    * Manage Post Request
    *
    * @return void
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'trigger_marker_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:100000',
        ]);
        $imageName = time().'.'.$request->trigger_marker_file->getClientOriginalExtension();
        
        $request->trigger_marker_file->move(storage_path('app/uploads/triggermarkers'), $imageName);

        $image = new TriggerMarker;
        $image->parent_id = $request->parent_id;
        $image->file = $imageName;
        $image->save();

        return back()
            ->with('success','You have successfully uploaded an image.')
            ->with('image',$imageName);
    }

    public function destroy($id)
    {
        $image = TriggerMarker::find($id);
        
        $section_id = $image->parent_id;
        Storage::delete('uploads/triggermarkers/'.$image->file);
        $image->delete();
        return redirect('/section/'.$section_id)->with('success','TriggerMarker deleted.');
    }
}