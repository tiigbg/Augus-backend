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
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);
        $imageName = time().'.'.$request->image_file->getClientOriginalExtension();
        $request->image_file->move(public_path('images'), $imageName);

        $image = new Image;
        $image->parent_id = $request->parent_id;
        $image->file = $imageName;
        $image->save();

        return back()
            ->with('success','You have successfully uploaded an image.')
            ->with('image',$imageName);
    }

    public function destroy($id)
    {
        $image = Image::find($id);
        $texts = $image->texts()->get();
        foreach ($texts as $text) {
            App('App\Http\Controllers\TextController')->destroy($text->id);
        }
        $section_id = $image->parent_id;
        $image->delete();
        return redirect('/section/'.$section_id)->with('success','Image deleted.');
    }
}