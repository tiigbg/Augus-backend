<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Video;
use Storage;

class VideoController extends Controller
{
    public function videoFile($id)
    {
        $video = Video::find($id);
        $contents = Storage::disk('local')->get('uploads/video/'.$video->file);
        $response = Response($contents);
        $response->header('Content-Type', 'video');
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
        //$video = Video::find($id);
        //$data = [
        //    'video' => $video
        // ];
        //return view('video', $data);

    }

    public function index()
    {
        //
    }

     public function create()
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    /**
    * Manage Post Request
    *
    * @return void
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'video_file' => 'required|mimes:mp4,avi|max:50000',
        ]);
        $videoName = time().'.'.$request->video_file->getClientOriginalExtension();
        $request->video_file->move(storage_path('app/uploads/video'), $videoName);

        $video = new Video;
        $video->parent_id = $request->parent_id;
        $video->language = $request->language;
        $video->file = $videoName;
        $video->save();

        return back()
            ->with('success','You have successfully uploaded a video.')
            ->with('video',$videoName);
    }

    public function destroy($id)
    {
        $video = Video::find($id);
        $section_id = $video->parent_id;
        Storage::delete('uploads/video/'.$video->file);
        $video->delete();
        return redirect('/section/'.$section_id)->with('success','Video deleted.');
    }
}