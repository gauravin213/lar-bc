<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Orderitem;
use App\Models\Pricelist;
use App\Models\User;
use App\Models\CustomerTransaction;
use Illuminate\Http\Request;
use Session;
use DB;

use File;
use Response;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cart = [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user_type = auth()->user()->user_type;

        if ($user_type == 'administrator') {
            $customers = Customer::all();
            $users = User::all();
        }else{
            $customers = Customer::where('sales_persone_id', $user_id)->get();
            $users = User::where('id', $user_id)->get();
        }

       
        $args_filter = [];
        if (count($_GET)!=0) {
            foreach ($_GET as $key => $value) {
                if ( !in_array($key, ['page']) ) {
                    if ($value!='') {
                        $args_filter[$key] = $value;
                    }
                }
            }
            if ($user_type != 'administrator') {
                $args_filter['placed_by'] = $user_id;
            }
        }

       // echo "<pre>args_filter: "; print_r($args_filter); echo "</pre>";

        if (count($args_filter)!=0) {

            unset($args_filter['from_date']);
            unset($args_filter['to_date']);

            if ( (isset($_GET['from_date']) && !empty($_GET['from_date'])) && isset($_GET['to_date']) ) {  

                $from_date = ($_GET['from_date']!='') ? date("Y-m-d 00:00:00", strtotime($_GET['from_date'])) : '';
                $to_date = ($_GET['to_date']!='')? date("Y-m-d 23:59:59", strtotime($_GET['to_date'])): date("Y-m-d 23:59:59", strtotime($_GET['from_date']));

                /*echo "<pre>args_filter: "; print_r($args_filter); echo "</pre>";
                echo "from_date: ".$from_date; echo "<br>";
                echo "to_date: ".$to_date; echo "<br>";*/

                $orders = Order::with(['user', 'customer'])->where($args_filter)->whereBetween('created_at',[$from_date, $to_date])->orderBy('id', 'DESC')->paginate(10);

                $args_filter['from_date'] = $_GET['from_date'];
                $args_filter['to_date'] = $_GET['to_date'];

            }else{ 
                $orders = Order::with(['user', 'customer'])->where($args_filter)->orderBy('id', 'DESC')->paginate(10);
            }

        }else{
            if ($user_type == 'administrator') {
                $orders = Order::with(['user', 'customer'])->orderBy('id', 'DESC')->paginate(10);
            }else{
                $orders = Order::with(['user', 'customer'])->where('placed_by', $user_id)->orderBy('id', 'DESC')->paginate(10);
            }
        }


        //echo "<pre>args_filter:"; print_r($args_filter); echo "</pre>";

        return view('orders.index', ['customers' => $customers, 'users' => $users, 'orders' => $orders, 'args_filter' => $args_filter, 'user_type'=> $user_type]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $user = auth()->user();
        $user_id = $user->id;
        $user_type = $user->user_type;

        if (in_array($user_type, ['administrator'])) {
            $customers = Customer::all();
        }else{
            $customers = Customer::where('sales_persone_id', $user_id)->get();
        }
        
        $products = Product::all();
        return view('orders.create', ['customers' => $customers, 'products' => $products, 'user_id' => $user_id]);
    }

    public function exportcsv(Request $request)
    {      

        $data = $request->all();
        //echo "<pre>data:"; print_r($data); echo "</pre>";
       
        $args_filter = [];
        if (count($data)!=0) {
            foreach ($data as $key => $value) {
                if ( !in_array($key, ['page']) ) {
                    if ($value!='') {
                        $args_filter[$key] = $value;
                    }
                }
            }
        }
        //echo "<pre>args_filter: "; print_r($args_filter); echo "</pre>";


        if (count($args_filter)!=0) {
            unset($args_filter['from_date']);
            unset($args_filter['to_date']);

             if ( (isset($_GET['from_date']) && !empty($_GET['from_date'])) && isset($_GET['to_date']) ) {  
                $from_date = ($_GET['from_date']!='') ? date("Y-m-d 00:00:00", strtotime($_GET['from_date'])) : '';
                $to_date = ($_GET['to_date']!='')? date("Y-m-d 23:59:59", strtotime($_GET['to_date'])): date("Y-m-d 23:59:59", strtotime($_GET['from_date']));
                
                /*echo "<pre>args_filter: "; print_r($args_filter); echo "</pre>";
                echo "from_date: ".$from_date; echo "<br>";
                echo "to_date: ".$to_date; echo "<br>";*/

                $orders = Order::with(['user', 'customer', 'items'])->where($args_filter)->whereBetween('created_at',[$from_date, $to_date])->orderBy('id', 'DESC')->get();

            }else{ 
                $orders = Order::with(['user', 'customer', 'items'])->where($args_filter)->orderBy('id', 'DESC')->get();
            }
        }else{
            $orders = Order::with(['user', 'customer', 'items'])->get();
        }

        /*foreach ($orders as $order) {
            foreach ($order->items as $item) {
                echo "-->".$order->id.' - '.$item->name; echo "<br>";  
            }
        }
        die;*/

        //$orders = Order::all();

        // these are the headers for the csv file.
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=orders-download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );


        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        //creating the download file
        $filename =  public_path("files/orders-download.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
       /* fputcsv($handle, [
            "ID",
            "Payment Status",
            "Placed By",
            "Customer Id",
            "Subtotal",
            "Discount",
            "Discount_price",
            "Shipping",
            "Shipping Address",
            "Shipping State",
            "Total",
            "Balance Amount",
            "Date"
        ]);*/

        //adding the data from the array
        /*foreach ($orders as $order) {

            $placed_by = (is_object($order->user)) ? $order->user->name : 'N/A';
            $customer_id = (is_object($order->customer)) ? $order->customer->name : 'N/A';

            fputcsv($handle, [
                $order->id,
                $order->payment_status,
                $placed_by,
                $customer_id,
                $order->subtotal,
                $order->discount,
                $order->discount_price,
                $order->shipping,
                $order->shipping_address,
                $order->shipping_state,
                $order->total,
                $order->balance_amount,
                $order->created_at
            ]);

        }*/


        fputcsv($handle, [
            "ID",
            "Payment Status",
            "Placed By",
            "Customer Name",
            //"Discount",
            //"Discount Price",
            //"Balance Amount",
            "Shipping State", //issue
            "Shipping Address",
            "Remark",
            "Subtotal",
            "Shipping/Freight",
            "Total",
            "Date",

            "Item ID",
            "Item Name",
            "Item Price",
            "Item Quantity",
            "Item Line Subtotal",
            "Item Discount",
            //"Item Discount Price",

        ]);


        foreach ($orders as $order) {

            $placed_by = (is_object($order->user)) ? $order->user->name : 'N/A';
            $customer_id = (is_object($order->customer)) ? $order->customer->name : 'N/A';

            foreach ($order->items as $item) {

                $shipping_state = '';
                if ($order->shipping_state == 1) {
                   $shipping_state = 'UP/MP/Chhattisgarh';
                }else if($order->shipping_state == 2){
                    $shipping_state = 'Bihar/Jharkhand';
                }else{
                    $shipping_state = '';
                }

                fputcsv($handle, [
                    $order->id,
                    $order->payment_status,
                    $placed_by,
                    $customer_id,
                    //$order->discount,
                    //$order->discount_price,
                    //$order->balance_amount,
                    $shipping_state,
                    $order->shipping_address,
                    $order->remark,
                    $order->subtotal,
                    $order->shipping,
                    $order->total,
                    $order->created_at,

                    $item->product_id,
                    $item->name,
                    $item->price,
                    $item->qty,
                    $item->line_subtotal,
                    $item->item_discount,
                    //$item->item_discount_price,

                ]);
            }

        }


        fclose($handle);

        //download command
        return Response::download($filename, "orders-download.csv", $headers);

        //end export
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
            'payment_status' => 'required',
            'placed_by' => 'required',
            'customer_id' => 'required',
            'iten_data' => 'required'
        ]);

        $data = $request->all();
        $iten_data = $request->iten_data;
        $res = $this->calculate_totals($data);
       /* echo "<pre>"; print_r($data); echo "</pre>";  
        echo "<pre>"; print_r($res); echo "</pre>";  
        die;*/

        //save order
        $order = new Order();
        $order->payment_status  = $res['payment_status'];
        $order->placed_by       = $res['placed_by'];
        $order->customer_id     = $res['customer_id'];
        $order->subtotal        = $res['subtotal'];
        $order->discount        = $res['discount'];
        $order->discount_price  = $res['discount_price'];
        $order->shipping        = $res['shipping'];
        $order->shipping_state  = $res['shipping_state'];
        $order->shipping_address  = $res['shipping_address'];
        $order->remark            = $res['remark'];
        $order->total             = $res['total'];
        $order->save();

        $order_id = $order->id;

        //save order items
        $inserted_order_id = $order->id;
        foreach ($res['iten_data'] as $line_item) {
            $order_item = new Orderitem();
            $order_item->product_id = $line_item['product_id'];
            $order_item->name = Product::find($line_item['product_id'])->name;
            $order_item->price = $line_item['price'];
            $order_item->item_discount = $line_item['item_discount']; 
            $order_item->item_discount_price = $line_item['item_discount_price'];
            $order_item->qty = $line_item['qty'];
            $order_item->line_subtotal = $line_item['line_subtotal'];
            $order_item->order_id = $inserted_order_id;
            $order_item->save();
        }

        //customer transaction create
        $user_id = $res['placed_by'];
        $customer_id = $res['customer_id'];
        $description = "Order ID: #".$order_id;
        $attachment_path = '';
        $amount = $res['total'];
        $transaction_type = 'debit';
        $trans_status = 'successful';
        CustomerTransaction::create_customer_transaction($user_id, $customer_id, $order_id, $description, $attachment_path, $amount, $transaction_type, $trans_status);
        //customer transaction create end

        //return redirect()->route('orders.index')->with('success','Order added successfully');
        return redirect('admin/orders/'.$inserted_order_id.'/edit')->with('success','Order added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {   
        $order = Order::with(['user', 'customer', 'items', 'transaction'])->find($order->id);
        return view('orders.show', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $ord_arr = [];

        $user = auth()->user();
        $user_id = $user->id;
        $user_type = $user->user_type;

        if (in_array($user_type, ['administrator'])) {
            $customers = Customer::all();
        }else{
            $customers = Customer::where('sales_persone_id', $user_id)->get();
        }

        $products = Product::all();
        $order_items = Orderitem::where('order_id', $order->id)->get();
        return view('orders.edit', ['user_id' => $user_id, 'customers' => $customers, 'order' => $order, 'products' => $products, 'order_items' => $order_items]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {   
        /*$request->validate([
            'payment_status' => 'required',
            'placed_by' => 'required',
            'customer_id' => 'required',
            'iten_data' => 'required'
        ]);*/

        $data = $request->all();
        $iten_data = $request->iten_data;
        $res = $this->calculate_totals($data);
        //echo "<pre>all: "; print_r($data); echo "</pre>";
        //echo "<pre>Res: "; print_r($res); echo "</pre>";
        //die;

        //update order items
        foreach ($res['iten_data'] as $line_item) {
            $up_arr = [
                'product_id'    => $line_item['product_id'],
                'name'          => Product::find($line_item['product_id'])->name,
                'price'         => $line_item['price'],
                'item_discount' => $line_item['item_discount'],
                'item_discount_price' => $line_item['item_discount_price'], 
                'qty'           => $line_item['qty'],
                'line_subtotal' => $line_item['line_subtotal'],
                'order_id'      => $order->id
            ];
            Orderitem::where('id',$line_item['id'])->update($up_arr);
        }

        //update order
        $order->payment_status  = $res['payment_status'];
        //$order->placed_by       = $res['placed_by'];
        $order->customer_id     = $res['customer_id'];
        $order->subtotal        = $res['subtotal'];
        $order->discount        = $res['discount'];
        $order->discount_price  = $res['discount_price'];
        $order->shipping        = $res['shipping'];
        $order->shipping_state  = $res['shipping_state'];
        $order->shipping_address  = $res['shipping_address'];
        $order->remark  = $res['remark'];
        $order->total           = $res['total'];
        $order->update();

        //customer transaction
        $customer_transaction = CustomerTransaction::where('order_id', $order->id)->first();
        if (!empty($customer_transaction)) {
            //Update
            $trans_id = $customer_transaction->id;
            $user_id = $customer_transaction->user_id;
            $customer_id = $customer_transaction->customer_id;
            $order_id = $customer_transaction->order_id;
            $description = $customer_transaction->description;
            $attachment_path = $customer_transaction->attachment;
            $debit = $customer_transaction->debit;
            $credit = $customer_transaction->credit;
            $amount = $res['total'];
            if (!empty($debit)) {
                $trans_action = 'debit';
            }else{
                $trans_action = 'credit';
            }
            $trans_status = $customer_transaction->status;
            CustomerTransaction::update_customer_transaction($trans_id, $user_id, $customer_id, $order_id, $description, $attachment_path, $amount, $trans_action, $trans_status);
        }else{
            //create
            $user_id = $res['placed_by'];
            $customer_id = $res['customer_id'];
            $description = "#".$order->id;
            $attachment_path = '';
            $amount = $res['total'];
            $transaction_type = 'debit';
            $trans_status = 'successful';
            CustomerTransaction::create_customer_transaction($user_id, $customer_id, $order->id, $description, $attachment_path, $amount, $transaction_type, $trans_status);
        }
        //customer transaction end

        //return redirect()->route('orders.index')->with('success','Order updated successfully');
        return redirect('admin/orders/'.$order->id.'/edit')->with('success','Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success','Order deleted successfully');
    }

    /*
    * Search item ajax
    */
    public function searchitem(Request $request)
    {   
        $searck_key = $request->searck_key;
        $products = Product::where('name', 'LIKE', "%{$searck_key}%") ->get();
        return response()->json($products);
    }

    /*
    * Add item ajax
    */
    public function additem(Request $request)
    {   
        $response = [];
        $iten_data = $request->iten_data;
        $product_ids = [];
        $product_qty = [];
        foreach ($iten_data as $data) {
            if (!empty($data['product_id'])) {
               $product_ids[] = $data['product_id'];
               $product_qty[$data['product_id']] = $data['qty'];
            }
        }
        $products = Product::whereIn('id', $product_ids)->get();
        $main_arr = [];
        $subtotal = 0;
        $total = 0;
        foreach ($products as $key => $product) {
            $price = $product->price;
            $qty = $product_qty[$product->id];
            $line_subtotal = $price * $qty;
            $main_arr['iten_data'][] = [
                'id'    => $key,
                'product_id'  => $product->id,
                'name'  => $product->name,
                'price'  => $price,
                'item_discount'  => 0,
                'item_discount_price'  => 0,
                'qty'   => $qty,
                'line_subtotal' => $line_subtotal
            ];
            $subtotal = $subtotal + $line_subtotal;
            $total = $total + $line_subtotal;
        }
        $main_arr['subtotal'] = $subtotal;
        $main_arr['discount'] = 0;
        $main_arr['discount_price'] = 0;
        $main_arr['shipping'] = 0;
        $main_arr['total'] = $total;
        return response()->json($main_arr);
    }

    /*
    * 
    */
    public function calculate_order(Request $request)
    {   
        $data = $request->all();
        $res = $this->calculate_totals($data);
        return response()->json($res);
    }


    /*
    * Calculate order totals
    */
    public function calculate_totals($cart_data) 
    {      
        $subtotal = 0;
        $total = 0;
        foreach ($cart_data['iten_data'] as $key => $items) {

            //Product obj
            $product = Product::find($items['product_id']);

            //set name
            $cart_data['iten_data'][$key]['name'] = $product->name;

            //Pricelist
            if (!empty($cart_data['price_date'])) {
                 $pricelist = Pricelist::select('*')
                ->where('price_date', '=', $cart_data['price_date'])
                ->where('product_id', '=', $items['product_id'])
                ->where('state', '=', $cart_data['shipping_state'])
                ->get();
                if (count($pricelist) !=0) {
                    $cart_data['iten_data'][$key]['price'] = $pricelist[0]->price;
                    $price = $pricelist[0]->price;
                }else{
                    $org_price = Product::find($items['product_id'])->price;
                    $cart_data['iten_data'][$key]['price'] = $org_price;
                    $price = $org_price;
                }
            }else{
                $org_price = Product::find($items['product_id'])->price;
                $cart_data['iten_data'][$key]['price'] = $org_price;
                $price = $org_price;
            }

            //item discount
            if (isset($cart_data['category_discount']) && !empty($cart_data['category_discount'])) {
                
                //$item_discount = $items['item_discount'];
                if (isset($cart_data['category_discount'][$product->category_id])) {
                    $item_discount = $cart_data['category_discount'][$product->category_id];
                    $item_discount_price = $price * $item_discount / 100;
                    $item_final_price = $price - $item_discount_price;
                    $price = $item_final_price;
                    $cart_data['iten_data'][$key]['item_discount'] = $item_discount;
                    $cart_data['iten_data'][$key]['item_discount_price'] = $item_final_price;
                }else{
                    $cart_data['iten_data'][$key]['item_discount'] = 0;
                    $cart_data['iten_data'][$key]['item_discount_price'] = 0;
                }
            }else{
                $cart_data['iten_data'][$key]['item_discount'] = 0;
                $cart_data['iten_data'][$key]['item_discount_price'] = 0;
            }
           /*$item_discount = $items['item_discount'];
            if ($item_discount!=0) {
                $item_discount_price = $price * $item_discount / 100;
                $item_final_price = $price - $item_discount_price;
                $price = $item_final_price;
                $cart_data['iten_data'][$key]['item_discount_price'] = $item_final_price;
            }else{
                $cart_data['iten_data'][$key]['item_discount'] = 0;
                $cart_data['iten_data'][$key]['item_discount_price'] = 0;
            }*/
            //end item discount


            $qty = $items['qty'];

            $line_subtotal = $price * $qty;

            //line subtotal cal
            $cart_data['iten_data'][$key]['line_subtotal'] = $line_subtotal;

            //subtotal cal
            $subtotal = $subtotal + $line_subtotal;
        }
        
        $cart_data['subtotal'] = $subtotal;

        //discount cal
        $discount = $cart_data['discount'];
        if ($discount!=0) {
            $discount_price = $subtotal * $discount / 100;
            $cart_data['discount_price'] = $discount_price;
            $final_price = $subtotal - $discount_price;
            $cart_data['total'] = $final_price - $cart_data['shipping'];
        }else{
            $cart_data['discount'] = 0;
            $cart_data['discount_price'] = 0;
            $cart_data['total'] = $subtotal - $cart_data['shipping'];
        }

        $temp = [];
        foreach ($cart_data['iten_data'] as $key => $items) {
           $temp[] = $cart_data['iten_data'][$key];
        }
        $cart_data['iten_data'] = [];
        $cart_data['iten_data'] = $temp;

        //echo "<pre>"; print_r($cart_data); echo "</pre>";  die;
        
        return $cart_data;
    }

    public function get_product_category(Request $request)
    {      

        $iten_data = $request->iten_data;
        $category_ids = [];
        if (!empty($iten_data)) {
            foreach ($iten_data as $key => $items) {
                $product = Product::find($items['product_id']);
                $category_ids[] = $product->category_id;
            }
        }
        
        $categories = [];
        if (!empty($category_ids)) {
            $category_ids = array_unique($category_ids);
            $category_ids = implode(",", $category_ids);
            $q = "SELECT * FROM categories WHERE id IN({$category_ids})";
            $cat_result = DB::select($q); 
            $categories = $cat_result;
        }

        return response()->json($categories);
    }


    public function get_product_name($product_id)
    {
        $product = Product::find($product_id);
        if (is_object($product)) {
            return $product->name;
        }else{
            return '--';
        }
    }

    public function get_user_name($user_id)
    {
        $user = User::find($user_id);
        if (is_object($user)) {
            return $user->name;
        }else{
            return '--';
        }
        
    }

    public function get_customer_name($customer_id)
    {
        $customer = Customer::find($customer_id);
        if (is_object($customer)) {
            return $customer->name;
        }else{
            return '--';
        }
        
    }

}
