<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Audio;
use Storage;


class AudioController extends Controller
{
    public function audioFile($id)
    {
        $audio = Audio::find($id);
        $contents = Storage::disk('local')->get('uploads/audio/'.$audio->file);
        $response = Response($contents);
        $response->header('Content-Type', 'audio');
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
        //$audio = Audio::find($id);
        //$data = [
        //    'audio' => $audio
        // ];
        //return view('audio', $data);

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
        //echo $request->audio_file->getMimeType();
        

        // $this->validate($request, [
        //     'audio_file' => 'required|max:50000',
        //     $request->audio_file->getClientOriginalExtension() => 'mp3',
        // ]);


        $audioName = time().'.'.$request->audio_file->getClientOriginalExtension();
        $request->audio_file->move(storage_path('app/uploads/audio'), $audioName);

        $audio = new Audio;
        $audio->parent_id = $request->parent_id;
        $audio->parent_type = $request->parent_type;
        $audio->language = $request->language;
        $audio->file = $audioName;
        $audio->save();

        return back()
            ->with('success','You have successfully uploaded an audio.')
            ->with('audio',$audioName);
    }

    public function destroy($id)
    {
        $audio = Audio::find($id);
        $parent_id = $audio->parent_id;
        $parent_type = $audio->parent_type;
        Storage::delete('uploads/audio/'.$audio->file);
        $audio->delete();
        if($parent_type == 'image')
        {
            return redirect('/images/'.$parent_id)->with('success','Audio deleted.');
        }
        return redirect('/section/'.$parent_id)->with('success','Audio deleted.');
    }
}