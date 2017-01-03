<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Video;

class VideoController extends Controller
{
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
        $request->video_file->move(public_path('videofiles'), $videoName);

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
        $video->delete();
        return redirect('/section/'.$section_id)->with('success','Video deleted.');
    }
}