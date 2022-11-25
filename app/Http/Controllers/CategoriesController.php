<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get()->toArray();
        $query = false;
        return view('categories/index', compact('categories' , 'query'));
    }

    /**
     * Search based on Category's Name
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $categories = [];
        $query = strtolower($request->categoryQuery);
        $allCategories = Category::all()->toArray();
        foreach ($allCategories as $category) {
            if (str_contains(strtolower($category["name"]), $query)) {
                $categories[] = $category;
            }
        }
        return view('categories/index', compact('categories','query'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->categoryName;
        if (Category::where(['name' => $category->name])->get()->count() > 0 ) {
            return \Redirect::back()->withErrors(['msg' => 'Category Exists']);
        } else {
            $category->save();
        }
        
        return redirect('categories');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->categoryName;
        $category->save();
        return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect('categories');
    }
}
