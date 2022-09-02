<?php

namespace App\Http\Controllers;

use App\Models\Pricelist;
use App\Models\Product;
use Illuminate\Http\Request;

use File;
use Response;

class PricelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $args_filter = [];
        if (count($_GET)!=0) {
            foreach ($_GET as $key => $value) {
                if ( !in_array($key, ['page']) ) {
                    if ($value!='') {
                        
                        if ($key == 'from_date') {
                           $args_filter['price_date'] = $value;
                        }else{
                           $args_filter[$key] = $value;
                        }
                    }
                }
            }
        }

        //echo "<pre>args_filter: "; print_r($args_filter); echo "</pre>"; //die;

        if (!empty($args_filter)) {
            $pricelists = Pricelist::with('product')->where($args_filter)->orderBy('id', 'DESC')->paginate(10);
        }else{
            $pricelists = Pricelist::with('product')->orderBy('id', 'DESC')->paginate(10);
        }

        return view('pricelists.index', ['pricelists' => $pricelists]);
    }


    public function exportcsv(Request $request)
    {      

        $args_filter = [];
        if (count($_GET)!=0) {
            foreach ($_GET as $key => $value) {
                if ( !in_array($key, ['page']) ) {
                    if ($value!='') {
                        
                        if ($key == 'from_date') {
                           $args_filter['price_date'] = $value;
                        }else{
                           $args_filter[$key] = $value;
                        }
                    }
                }
            }
        }

        //echo "<pre>args_filter: "; print_r($args_filter); echo "</pre>"; die;

        if (!empty($args_filter)) {
            $pricelists = Pricelist::where($args_filter)->orderBy('id', 'DESC')->paginate(10);
        }else{
            $pricelists = Pricelist::orderBy('id', 'DESC')->paginate(10);
        }

        //dd($pricelists);

        /*if ( (isset($_GET['from_date']) && $_GET['from_date'] !='') ) {
            $from_date = $_GET['from_date'];
            $pricelists = Pricelist::where('price_date',$from_date)->orderBy('id', 'DESC')->get();
        }else{
            $pricelists = Pricelist::orderBy('id', 'DESC')->get();
        }*/

       

        // these are the headers for the csv file.
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=pricelists-download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );


        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        //creating the download file
        $filename =  public_path("files/pricelists-download.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
            "ID",
            'Product Id',
            'Price date',
            'State',
            'Price',
            'Created At'
        ]);

        //adding the data from the array
        foreach ($pricelists as $pricelist) {
            fputcsv($handle, [
                $pricelist->id,
                $pricelist->product_id,
                $pricelist->price_date,
                $pricelist->state,
                $pricelist->price,
                $pricelist->created_at
            ]);

        }
        fclose($handle);

        //download command
        return Response::download($filename, "pricelists-download.csv", $headers);

        //end export
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $products = Product::all();
        return view('pricelists.create', ['user_id' => $user_id, 'products' => $products]);
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
            'product_id' => 'required',
            'price_date' => 'required'
        ]);

        $pricelist = new Pricelist();
        $pricelist->product_id = $request->product_id;
        $pricelist->price_date = $request->price_date;
        $pricelist->state = $request->state;
        $pricelist->price = $request->price;
        $pricelist->save();
        return redirect()->route('pricelists.index')->with('success','Price added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pricelist  $pricelist
     * @return \Illuminate\Http\Response
     */
    public function show(Pricelist $pricelist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pricelist  $pricelist
     * @return \Illuminate\Http\Response
     */
    public function edit(Pricelist $pricelist)
    {
        $user_id = auth()->user()->id;
        $products = Product::all();
        return view('pricelists.edit', ['user_id' => $user_id, 'pricelist' => $pricelist, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pricelist  $pricelist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pricelist $pricelist)
    {
        $request->validate([
            'product_id' => 'required',
            'price_date' => 'required'
        ]);

        $pricelist->product_id = $request->product_id;
        $pricelist->price_date = $request->price_date;
        $pricelist->state = $request->state;
        $pricelist->price = $request->price;
        $pricelist->update();
        return redirect()->route('pricelists.index')->with('success','Price updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pricelist  $pricelist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pricelist $pricelist)
    {
        $pricelist->delete();
        return redirect()->route('pricelists.index')->with('success','Price deleted successfully');
    }

    public function get_product_name($product_id)
    {
        $product_name = Product::find($product_id);
        return $product_name->name;
    }
}
