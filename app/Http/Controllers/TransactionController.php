<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

use File;
use Response;

class TransactionController extends Controller
{
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

        //echo "<pre>"; print_r($args_filter); echo "</pre>"; die;

        if (count($args_filter)!=0) {
            unset($args_filter['from_date']);
            unset($args_filter['to_date']);
             //$orders = Order::where($args_filter)->orderBy('id', 'DESC')->get();
             if ( (isset($_GET['from_date']) && !empty($_GET['from_date'])) && isset($_GET['to_date']) ) {  
                $from_date = ($_GET['from_date']!='') ? date("Y-m-d 00:00:00", strtotime($_GET['from_date'])) : '';
                $to_date = ($_GET['to_date']!='')? date("Y-m-d 23:59:59", strtotime($_GET['to_date'])): date("Y-m-d 23:59:59", strtotime($_GET['from_date']));

               /* echo "<pre>args_filter: "; print_r($args_filter); echo "</pre>";
                echo "from_date: ".$from_date; echo "<br>";
                echo "to_date: ".$to_date; echo "<br>";*/

                $transactions = Transaction::with(['order', 'customer', 'user'])->where($args_filter)->whereBetween('created_at',[$from_date, $to_date])->orderBy('id', 'DESC')->paginate(10);

                $args_filter['from_date'] = $_GET['from_date'];
                $args_filter['to_date'] = $_GET['to_date'];

            
            }else{
                //$orders = Order::where($args_filter)->orderBy('id', 'DESC')->paginate(10);
                 $transactions = Transaction::with(['order', 'customer', 'user'])->where($args_filter)->orderBy('id', 'DESC')->paginate(10);
            }


            
        }else{
            if ($user_type == 'administrator') {
                //$orders = Order::orderBy('id', 'DESC')->get();
                 $transactions = Transaction::with(['order', 'customer', 'user'])->orderBy('id', 'DESC')->paginate(10);
            }else{
                //$orders = Order::where('placed_by', $user_id)->orderBy('id', 'DESC')->get();
                $transactions = Transaction::with(['order', 'customer', 'user'])->where('placed_by', $user_id)->orderBy('id', 'DESC')->paginate(10);
            }
        }


       /* $order_ids = [];
        if (count($orders)!=0) {
            foreach ($orders as $order) {
               $order_ids[] = $order->id;
            }
        }
        $transactions = Transaction::with(['order', 'customer', 'user'])->whereIn('order_id', $order_ids)->orderBy('id', 'DESC')->paginate(10);*/

        return view('transactions.index', ['transactions'=>$transactions, 'customers'=>$customers, 'users'=>$users, 'args_filter' => $args_filter, 'user_type'=>$user_type]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $order_id = $request->order_id;
        $user_id = auth()->user()->id;
        $order = Order::with(['customer', 'user'])->where('id', $order_id)->first();
        return view('transactions.create', ['user_id' => $user_id, 'order' => $order]);
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

                //$orders = Order::where($args_filter)->whereBetween('created_at',[$from_date, $to_date])->orderBy('id', 'DESC')->paginate(10);

                /*echo "<pre>args_filter: "; print_r($args_filter); echo "</pre>";
                echo "from_date: ".$from_date; echo "<br>";
                echo "to_date: ".$to_date; echo "<br>";*/

                $transactions = Transaction::with(['order', 'customer', 'user'])->where($args_filter)->whereBetween('created_at',[$from_date, $to_date])->orderBy('id', 'DESC')->get();

            }else{ 
                $transactions = Transaction::with(['order', 'customer', 'user'])->where($args_filter)->orderBy('id', 'DESC')->get();
            }
        }else{
            $transactions = Transaction::with(['order', 'customer', 'user'])->get();
        }

        /*foreach ($transactions as $transaction) {
            echo "-->".$transaction->id; echo "<br>";       
        }
        die;*/

        //$transactions = Transaction::all();

        // these are the headers for the csv file.
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=transactions-download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );


        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        //creating the download file
        $filename =  public_path("files/transactions-download.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
            "ID",
            "Order Id",
            "Customer Name",
            "Placed By",
            "Paid Amount",
            "Balance Amount",
            "Mode of Payment",
            "Uploaded Receipt",
            "Remark",
            "Order Total",
        ]);

        //adding the data from the array
        foreach ($transactions as $transaction) {

            $placed_by = (is_object($transaction->user)) ? $transaction->user->name : 'N/A';
            $customer_id = (is_object($transaction->customer)) ? $transaction->customer->name : 'N/A';
            $order_total = (is_object($transaction->order)) ? $transaction->order->total : 'N/A';
            $upload_receipt = (!empty($transaction->upload_receipt)) ? url($transaction->upload_receipt) : 'N/A';


            fputcsv($handle, [
                $transaction->id,
                $transaction->order_id,
                $customer_id,
                $placed_by,
                $transaction->paid_amount,
                $transaction->ballance_amount,
                $transaction->mode_of_payment,
                $upload_receipt,
                $transaction->remark,
                $order_total
            ]);

        }
        fclose($handle);

        //download command
        return Response::download($filename, "transactions-download.csv", $headers);

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
        $order_total        = $request->order_total;
        $order_balance_amount = $request->order_balance_amount;
        $order_id           = $request->order_id;
        $customer_id        = $request->customer_id;
        $placed_by          = $request->placed_by;
        $paid_amount        = $request->paid_amount;
        $mode_of_payment    = $request->mode_of_payment;
        $upload_receipt     = $request->upload_receipt;
        $remark             = $request->remark;

        $total_fund_enable  = $request->total_fund_enable;
        $to_pay_x           = $request->to_pay_x;
        $balance_amount_x   = $request->balance_amount_x;
        $update_wallet_x    = $request->update_wallet_x;


        if ($total_fund_enable == 'yes' && $paid_amount!='') {  

            $ballance_amount = $order_total - ($to_pay_x + $paid_amount);

           /* echo "case 1"; echo "<br><br>";
            echo "order_total: ".$order_total; echo "<br>";
            echo "update_wallet_x: ".$update_wallet_x; echo "<br>";
            echo "to_pay_x: ".$to_pay_x; echo "<br>";
            echo "balance_amount_x: ".$balance_amount_x; echo "<br>";
            echo "paid_amount: ".$paid_amount; echo "<br><br>";
            echo "ballance_amount: ".$ballance_amount; echo "<br>";*/

            //Wallet entry
            $transaction = new Transaction();
            $transaction->order_id = $order_id;
            $transaction->customer_id = $customer_id;
            $transaction->placed_by = $placed_by;

            
            $transaction->paid_amount = $to_pay_x;
            $transaction->ballance_amount = 0;

            $transaction->mode_of_payment = 'wallet';
            $transaction->remark = $remark;

            if ($request->upload_receipt) {
                $upload_receipt_image = $request->file('upload_receipt')->getClientOriginalName();
                $upload_receipt_image_path = $request->file('upload_receipt')->store('uploads');
                $transaction->upload_receipt = $upload_receipt_image_path;
            }
            
            $transaction->save();
            //End Wallet entry

            //Payment method entry
            $transaction = new Transaction();
            $transaction->order_id = $order_id;
            $transaction->customer_id = $customer_id;
            $transaction->placed_by = $placed_by;

            $transaction->paid_amount = $paid_amount;
            $transaction->ballance_amount = $ballance_amount;

            $transaction->mode_of_payment = $mode_of_payment;
            $transaction->remark = $remark;

            if ($request->upload_receipt) {
                $upload_receipt_image = $request->file('upload_receipt')->getClientOriginalName();
                $upload_receipt_image_path = $request->file('upload_receipt')->store('uploads');
                $transaction->upload_receipt = $upload_receipt_image_path;
            }
            
            $transaction->save();
            //End Payment method entry

            //Update balance
            Order::where('id',$order_id)->update([
                'balance_amount' => $ballance_amount,
                'payment_status' => ($balance_amount_x > 0 )? 'pending' : 'processing'
            ]);

            //update wallet
            Customer::where('id',$customer_id)->update([
                'total_fund' => $update_wallet_x
            ]);

            
        }else if ($total_fund_enable == 'yes') { 

            /*echo "case 1 and case 3"; echo "<br><br>";
            echo "order_total: ".$order_total; echo "<br>";
            echo "update_wallet_x: ".$update_wallet_x; echo "<br>";
            echo "to_pay_x: ".$to_pay_x; echo "<br>";
            echo "balance_amount_x: ".$balance_amount_x; echo "<br>";
            echo "paid_amount: ".$paid_amount; echo "<br>";*/

            //Wallet entry
            $transaction = new Transaction();
            $transaction->order_id = $order_id;
            $transaction->customer_id = $customer_id;
            $transaction->placed_by = $placed_by;
            
            $transaction->paid_amount = $to_pay_x;
            $transaction->ballance_amount = $balance_amount_x;

            $transaction->mode_of_payment = 'wallet';
            $transaction->remark = $remark;

            if ($request->upload_receipt) {
                $upload_receipt_image = $request->file('upload_receipt')->getClientOriginalName();
                $upload_receipt_image_path = $request->file('upload_receipt')->store('uploads');
                $transaction->upload_receipt = $upload_receipt_image_path;
            }
            
            $transaction->save();
            //End Wallet entry

            //Update balance
            Order::where('id',$order_id)->update([
                'balance_amount' => $balance_amount_x,
                'payment_status' => ($balance_amount_x > 0 )? 'pending' : 'processing'
            ]); 

            //update wallet
            Customer::where('id',$customer_id)->update([
                'total_fund' => $update_wallet_x
            ]);
            
        }
        else{ 

            $request->validate([
                'paid_amount' => 'required',
                'mode_of_payment' => 'required'
            ]);

            $ballance_amount = $this->calculate_balance($order_id, $paid_amount);

            //echo "normal"; echo "<br><br>";
            //echo "order_total: ".$order_total; echo "<br>";
            //echo "paid_amount: ".$paid_amount; echo "<br>";
            //echo "order_balance_amount: ".$order_balance_amount; echo "<br>"; 
            //echo "ballance_amount: ".$ballance_amount; echo "<br>"; 
            //die;

            /*if ($paid_amount >  $order_balance_amount) { echo "string";
                return redirect()->route('transactions.index')->with('warning','Paid amount limit exceeded ');
            }*/


            if ($ballance_amount >= 0) {
                //Payment method entry
                $transaction = new Transaction();
                $transaction->order_id = $order_id;
                $transaction->customer_id = $customer_id;
                $transaction->placed_by = $placed_by;

                $transaction->paid_amount = $paid_amount;
                $transaction->ballance_amount = $ballance_amount;

                $transaction->mode_of_payment = $mode_of_payment;
                $transaction->remark = $remark;

                if ($request->upload_receipt) {
                    $upload_receipt_image = $request->file('upload_receipt')->getClientOriginalName();
                    $upload_receipt_image_path = $request->file('upload_receipt')->store('uploads');
                    $transaction->upload_receipt = $upload_receipt_image_path;
                }
                
                $transaction->save();
                //End Payment method entry

                //Update balance
                Order::where('id',$order_id)->update([
                    'balance_amount' => $ballance_amount,
                    'payment_status' => ($ballance_amount > 0 )? 'pending' : 'processing'
                ]);
            }else{
                echo "ballance_amount: ".$ballance_amount;
                die();
            }

            
        }


        //die;


        return redirect()->route('transactions.index')->with('success','Transaction added successfully');
        //return redirect('admin/orders/'.$res['order_id'].'/edit')->with('success','Payment added successfully');
    }

    public function calculate_balance($order_id, $paid_amount)
    {

        $order = Order::find($order_id);
        $order_total = $order->total;

        $total_paid = $paid_amount;
        $total_ballance_amount = 0;
        $transactions = Transaction::where('order_id', $order_id)->get();
        foreach ($transactions as $transaction) {
            $paid_amount = $transaction->paid_amount;
            $total_paid = $total_paid + $paid_amount;
        }
    
        $total_ballance_amount = $order_total - $total_paid;
      
        return $total_ballance_amount;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $user_id = auth()->user()->id;
        return view('transactions.edit', ['user_id' => $user_id, 'transaction' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //$data = $request->all();
        
        $request->validate([
            'order_id' => 'required',
            'paid_amount' => 'required'
        ]);

        /*$order = Order::find($request->order_id);
        if (is_object($order)) {
            Customer::where('id',$order->customer_id)->update(['balance_amount' => $request->ballance_amount]);
        }*/

        $transaction->order_id = $request->order_id;
        $transaction->customer_id = $request->customer_id; 
        //$transaction->placed_by = $request->placed_by;
        $transaction->paid_amount = $request->paid_amount;
        $transaction->ballance_amount = $request->ballance_amount;
        $transaction->mode_of_payment = $request->mode_of_payment;
        $transaction->remark = $request->remark;

        if ($request->upload_receipt) {
            $upload_receipt_image = $request->file('upload_receipt')->getClientOriginalName();
            $upload_receipt_image_path = $request->file('upload_receipt')->store('uploads');
            $transaction->upload_receipt = $upload_receipt_image_path;
        }

        $transaction->update();
        return redirect()->route('transactions.index')->with('success','Transaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success','Transaction deleted successfully');
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
