<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Signlanguage;

class SignlanguageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$signlanguage = Signlanguage::find($id);
        //$data = [
        //    'signlanguage' => $signlanguage
        // ];
        //return view('signlanguage', $data);

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
            'signlanguage_file' => 'required|mimes:mp4,avi,mov|max:50000',
        ]);
        $signlanguageName = time().'.'.$request->signlanguage_file->getClientOriginalExtension();
        $request->signlanguage_file->move(public_path('signlanguagefiles'), $signlanguageName);

        $signlanguage = new Signlanguage;
        $signlanguage->parent_id = $request->parent_id;
        $signlanguage->language = $request->language;
        $signlanguage->file = $signlanguageName;
        $signlanguage->save();

        return back()
            ->with('success','You have successfully uploaded a signlanguage video.')
            ->with('signlanguage',$signlanguageName);
    }

    public function destroy($id)
    {
        $signlanguage = Signlanguage::find($id);
        $section_id = $signlanguage->parent_id;
        $signlanguage->delete();
        return redirect('/section/'.$section_id)->with('success','Signlanguage video deleted.');
    }
}