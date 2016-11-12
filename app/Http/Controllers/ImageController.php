<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Image;

class ImageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::find($id);
        $data = [
            'image' => $image,
            'texts' => $image->texts
         ];
        return view('image', $data);
    }
    /**
    * Manage Post Request
    *
    * @return void
    */
    public function postImage(Request $request)
    {
        $this->validate($request, [
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        $imageName = time().'.'.$request->image_file->getClientOriginalExtension();
        $request->image_file->move(public_path('images'), $imageName);

        $image = new Image;
        $image->parent_id = $request->parent_id;
        $image->file = $imageName;
        $image->save();

        return back()
            ->with('success','You have successfully upload images.')
            ->with('image',$imageName);
    }
}