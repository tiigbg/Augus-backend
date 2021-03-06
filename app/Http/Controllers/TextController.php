<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Text;

class TextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $text = new Text;

        $text->parent_id = $request->parent_id;
        $text->parent_type = $request->parent_type;
        $text->type = $request->type;
        $text->language = $request->language;
        $text->text = $request->text;

        $text->save();
        //return redirect('/section/'.$request->parent_id);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $text = Text::find($request->id);

        if(isset($request->parent_id))
        {
            $text->parent_id = $request->parent_id;
        }
        if(isset($request->parent_type))
        {
            $text->parent_type = $request->parent_type;
        }
        if(isset($request->type))
        {
            $text->type = $request->type;
        }
        if(isset($request->language))
        {
            $text->language = $request->language;
        }
        if(isset($request->text))
        {
            $text->text = $request->text;
        }

        $text->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Text::find($id)->delete();
        return back();
    }
}
