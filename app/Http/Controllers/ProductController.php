<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        if ( !empty($_GET['s']) && !empty($_GET['category_id']) ) {
            $products = Product::query()
            ->with('category')
            ->where('name', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('description', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('price', 'LIKE', '%'.$_GET['s'].'%')
            ->orderBy('name', 'ASC')
            ->paginate(10);
        }else if( empty($_GET['s']) && !empty($_GET['category_id']) ){
            $products = Product::query()
            ->with('category')
            ->where('category_id', $_GET['category_id'])
            ->orderBy('name', 'ASC')
            ->paginate(10);
        }else if( !empty($_GET['s']) && !empty($_GET['category_id'])){
            $products = Product::query()
            ->with('category')
            ->where('name', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('description', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('price', 'LIKE', '%'.$_GET['s'].'%')
            ->where('category_id', $_GET['category_id'])
            ->orderBy('name', 'ASC')
            ->paginate(10);
        }else{
            $products = Product::with('category')->orderBy('name', 'ASC')->paginate(10);
        }

        $categories = Category::all();
        
        return view('products.index', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $categories = Category::all();
        return view('products.create', ['user_id' => $user_id, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       

        //$data = $request->all();
        //echo "<pre>"; print_r($data); echo "</pre>"; die;

        $request->validate([
            'name' => 'required',
            //'slug' => 'required'
        ]);

        $product = new Product();
        $product->name = $request->name;
        /*$product->slug = $request->slug;
        $product->sku = $request->sku;*/
        $product->description = $request->description;
        $product->price = $request->price;
        //$product->sale_price = $request->sale_price;
        $product->category_id = $request->category_id;
        $product->save();
        return redirect()->route('products.index')->with('success','Product added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $user_id = auth()->user()->id;
        $categories = Category::all();
        return view('products.edit', ['user_id' => $user_id, 'product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            //'slug' => 'required'
        ]);

        $product->name = $request->name;
        /*$product->slug = $request->slug;
        $product->sku = $request->sku;*/
        $product->description = $request->description;
        $product->price = $request->price;
        //$product->sale_price = $request->sale_price;
        $product->category_id = $request->category_id;
        $product->update();
        return redirect()->route('products.index')->with('success','Product added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    /*public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Product deleted successfully');
    }*/

    public function destroy($id)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Product deleted successfully');
    }

    public function destroy_bulk(Request $request)
    {
        $entity_ids = $request->entity_ids;
        $entity_ids = explode(",", $entity_ids);
        //echo "<pre>-->"; print_r($entity_ids); echo "</pre>"; die;
        Product::whereIn('id', $entity_ids)->delete();
        return redirect()->route('products.index')->with('success','Bulk Product deleted successfully');
    }
}
