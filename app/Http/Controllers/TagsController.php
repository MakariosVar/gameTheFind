<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->get()->toArray();
        $query = false;
        return view('tags/index', compact('tags' , 'query'));
    }

    /**
     * Search based on Tag's Name
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $tags = [];
        $query = strtolower($request->tagQuery);
        $alltag = Tag::all()->toArray();
        foreach ($alltag as $tag) {
            if (str_contains(strtolower($tag["name"]), $query)) {
                $tags[] = $tag;
            }
        }
        return view('tags/index', compact('tags','query'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new Tag;
        $tag->name = $request->tagName;
        if (Tag::where(['name' => $tag->name])->get()->count() > 0 ) {
            return \Redirect::back()->withErrors(['msg' => 'Tag Exists']);
        } else {
            $tag->save();
        }
        return redirect('tags');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo $request;
        echo $id;
        $tag = Tag::find($id);
        $tag->name = $request->tagName;
        $tag->save();
        return redirect('tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        $tag->delete();

        return redirect('tags');
    }
}
