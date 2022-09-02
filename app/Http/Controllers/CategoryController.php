<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !empty($_GET['s']) && empty($_GET['sales_persone_id']) ) {  //echo "string1";

            $categories = Category::query()
            ->where('name', 'LIKE', '%'.$_GET['s'].'%')
            ->orwhere('description', 'LIKE', '%'.$_GET['s'].'%')
             ->orwhere('parent', 'LIKE', '%'.$_GET['s'].'%')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        }else{
             $categories = Category::orderBy('id', 'DESC')->paginate(10);
        }
       
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        return view('categories.create', ['user_id' => $user_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            //'slug' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent = 0; //$request->parent;
        $category->save();
        return redirect()->route('categories.index')->with('success','Category added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $user_id = auth()->user()->id;
        return view('categories.edit', ['user_id' => $user_id, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            //'slug' => 'required'
        ]);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->parent = 0; //$request->parent;
        $category->update();
        return redirect()->route('categories.index')->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success','category deleted successfully');
    }
}
