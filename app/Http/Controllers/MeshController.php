<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Mesh;
use Storage;

class MeshController extends Controller
{

    public function meshFile($id)
    {
        $mesh = Mesh::find($id);
        $contents = Storage::disk('local')->get('uploads/meshes/'.$mesh->file);
        $response = Response($contents);
        $response->header('Content-Type', 'text/plain');
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
        // $mesh = Mesh::find($id);
        // $data = [
        //     'image' => $mesh
        //  ];
        // return view('image', $data);
    }
    /**
    * Manage Post Request
    *
    * @return void
    */
    public function store(Request $request)
    {
        /*$this->validate($request, [
            'mesh_file' => 'required|file|mimes:obj|max:100000',
        ]);*/
        $fileName = time().'.'.$request->mesh_file->getClientOriginalExtension();
        
        $request->mesh_file->move(storage_path('app/uploads/meshes'), $fileName);

        $mesh = new Mesh;
        $mesh->parent_id = $request->parent_id;
        $mesh->file = $fileName;
        $mesh->save();

        return back()
            ->with('success','You have successfully uploaded a mesh.')
            ->with('mesh',$fileName);
    }

    public function destroy($id)
    {
        $mesh = Mesh::find($id);
        $section_id = $mesh->parent_id;
        Storage::delete('uploads/meshes/'.$mesh->file);
        $mesh->delete();
        return redirect('/section/'.$section_id)->with('success','Mesh deleted.');
    }
}