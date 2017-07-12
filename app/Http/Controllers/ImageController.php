<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Image;
use Storage;

class ImageController extends Controller
{

    public function imageFile($id)
    {
        $image = Image::find($id);
        $contents = Storage::disk('local')->get('uploads/images/'.$image->file);
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
        $image = Image::find($id);
        $data = [
            'image' => $image,
            'texts' => $image->texts,
            'audios' => $image->audios
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
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:100000',
        ]);
        $imageName = time().'.'.$request->image_file->getClientOriginalExtension();
        
        $request->image_file->move(storage_path('app/uploads/images'), $imageName);

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
        Storage::delete('uploads/images/'.$image->file);
        $image->delete();
        return redirect('/section/'.$section_id)->with('success','Image deleted.');
    }
}