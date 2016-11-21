<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Audio;


class AudioController extends Controller
{
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
        $request->audio_file->move(public_path('audiofiles'), $audioName);

        $audio = new Audio;
        $audio->parent_id = $request->parent_id;
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
        $section_id = $audio->parent_id;
        $audio->delete();
        return redirect('/section/'.$section_id)->with('success','Audio deleted.');
    }
}