<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Icon;
use Storage;

class IconController extends Controller
{

    public function iconFile($id)
    {
        $icon = Icon::find($id);
        $contents = Storage::disk('local')->get('uploads/icons/'.$icon->file);
        $response = Response($contents);
        $response->header('Content-Type', 'icon');
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
        $icon = Icon::find($id);
        $data = [
            'icon' => $icon
         ];
         echo $icon;
        //return view('icon', $data);
    }
    /**
    * Manage Post Request
    *
    * @return void
    */
    public function postIcon(Request $request)
    {
        $this->validate($request, [
            'icon_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
        ]);
        $iconName = time().'.'.$request->icon_file->getClientOriginalExtension();
        
        $request->icon_file->move(storage_path('app/uploads/icons'), $iconName);

        $icon = new Icon;
        $icon->parent_id = $request->parent_id;
        $icon->file = $iconName;
        $icon->save();

        return back()
            ->with('success','You have successfully uploaded an icon.')
            ->with('icon',$iconName);
    }

    public function destroy($id)
    {
        $icon = Icon::find($id);
        $section_id = $icon->parent_id;
        Storage::delete('uploads/icons/'.$icon->file);
        $icon->delete();
        return redirect('/section/'.$section_id)->with('success','Icon deleted.');
    }
}