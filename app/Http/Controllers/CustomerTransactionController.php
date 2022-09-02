<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerTransaction;
use App\Models\CustomerTransactionLog;
use App\Models\CustomerBalance;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\Redirect;

class CustomerTransactionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($_GET['customer_id'])) {
           die("404");
        }

        $user = auth()->user();
        $user_id = $user->id;
        $user_type = $user->user_type;
        $customer_id = $_GET['customer_id'];
        $customer_transactions = CustomerTransaction::with(['user', 'customer'])->where(['customer_id' => $customer_id])->orderBy('id', 'ASC')->paginate(10);

        $customer_total_balance = CustomerBalance::get_customer_total_balance($customer_id);
        $total_debit = $customer_total_balance['total_debit'];
        $total_credit = $customer_total_balance['total_credit'];
        $total_balance = $customer_total_balance['total_balance'];

        return view('customer-transaction.index', [
                'customer_transactions' => $customer_transactions, 
                'user_id' => $user_id, 
                'user_type' => $user_type, 
                'total_debit' => $total_debit, 
                'total_credit' => $total_credit,
                'net_balance' => $total_balance
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!isset($_GET['customer_id'])) {
           die("404");
        }

        $user = auth()->user();
        $user_id = $user->id;
        $user_type = $user->user_type;
        $customer_id = $_GET['customer_id'];

        return view('customer-transaction.create', ['user_id' => $user_id, 'user_type' => $user_type, 'customer_id' => $customer_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = auth()->user();
        $user_id = $user->id;
        $user_type = $user->user_type;

        $request->validate([
            'amount' => 'required',
            'transaction_type' => 'required',
            'customer_id' => 'required'
        ]);

        $amount = $request->amount;
        $transaction_type = $request->transaction_type;
        $customer_id = $request->customer_id;
        $description = $request->description;


        $attachment_path = '';
        if ($request->attachment) {
            $attachment = $request->file('attachment')->getClientOriginalName();
            $attachment_path = $request->file('attachment')->store('uploads');
        }

        //create traction
        $order_id = 0;
        CustomerTransaction::create_customer_transaction($user_id, $customer_id, $order_id, $description, $attachment_path, $amount, $transaction_type);

        return Redirect::to('admin/customer-transactions?customer_id='.$customer_id)->with('success','Transaction Recored added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($customer_id, Request $request)
    {   

        /*$pppp = $request->all();
        echo "<pre>"; print_r($pppp); echo "</pre>";
        echo "customer_id: ".$customer_id; echo "<br>";
        die;*/

        $user = auth()->user();
        $user_id = $user->id;
        $user_type = $user->user_type;

        $customer_total_balance = CustomerBalance::get_customer_total_balance($customer_id);

        $total_debit = $customer_total_balance['total_debit'];
        $total_credit = $customer_total_balance['total_credit'];
        $total_balance = $customer_total_balance['total_balance'];
        $transaction_type = $customer_total_balance['transaction_type'];

        $customer = Customer::where('id', $customer_id)->first();

        $args_filter = [];
        if (count($_GET)!=0) {
            foreach ($_GET as $key => $value) {
                if ( !in_array($key, ['page']) ) {
                    if ($value!='') {
                        $args_filter[$key] = $value;
                    }
                }
            }
        }

        if (!empty($args_filter)) {
            $from_date = ($_GET['from_date']!='') ? date("Y-m-d 00:00:00", strtotime($_GET['from_date'])) : '';
            $to_date = ($_GET['to_date']!='')? date("Y-m-d 23:59:59", strtotime($_GET['to_date'])): date("Y-m-d 23:59:59", strtotime($_GET['from_date']));
            $customer_transactions = CustomerTransaction::with(['user', 'customer'])
            ->where(['customer_id' => $customer_id])
            ->whereBetween('created_at',[$from_date, $to_date])
            ->orderBy('id', 'ASC')->paginate(10);
        }else{ 
             $customer_transactions = CustomerTransaction::with(['user', 'customer'])
             ->where(['customer_id' => $customer_id])
             ->whereMonth('created_at', date("m"))
             ->whereYear('created_at', date("Y"))
             ->orderBy('id', 'ASC')
             ->paginate(10);
        }

        return view('customer-transaction.show', [
                'customer_transactions' => $customer_transactions, 
                'user_id' => $user_id, 
                'user_type' => $user_type, 
                'total_debit' => $total_debit, 
                'total_credit' => $total_credit,
                'net_balance' => $total_balance,
                'transaction_type' => $transaction_type,
                'customer' => $customer,
                'args_filter' => $args_filter
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $user = auth()->user();
        //$user_id = $user->id;
        $user_type = $user->user_type;

        $customer_transaction = CustomerTransaction::where('id', $id)->first();
        $trans_id = $customer_transaction->id;
        $user_id = $customer_transaction->user_id;
        $customer_id = $customer_transaction->customer_id;
        $description = $customer_transaction->description;
        $attachment_path = $customer_transaction->attachment;
        $debit = $customer_transaction->debit;
        $credit = $customer_transaction->credit;
        $transaction_type = $customer_transaction->transaction_type;
        $status = $customer_transaction->status;

        if ($debit > $credit) {
            $amount = $debit;
        }else{
            $amount = $credit;
        }

        return view('customer-transaction.edit', [
            'customer_transaction' => $customer_transaction,
            'user_id' => $user_id, 
            'user_type' => $user_type, 
            'customer_id' => $customer_id,
            'amount' => $amount
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required',
            'status' => 'required'
        ]);

        $amount = $request->amount;
        $description = $request->description;
        $status = $request->status;

        $attachment_path = '';
        if ($request->attachment) {
            $attachment = $request->file('attachment')->getClientOriginalName();
            $attachment_path = $request->file('attachment')->store('uploads');
        }

        //create traction
        $customer_transaction = CustomerTransaction::where('id', $id)->first();
        $trans_id = $customer_transaction->id;
        $user_id = $customer_transaction->user_id;
        $customer_id = $customer_transaction->customer_id;
        $description = $customer_transaction->description;
        $attachment_path = $customer_transaction->attachment;
        $debit = $customer_transaction->debit;
        $credit = $customer_transaction->credit;
        if (!empty($debit)) {
            $trans_action = 'debit';
        }else{
            $trans_action = 'credit';
        }

        //$status = 'successful'; //Req /failed pending successful
        /*echo "debit: ".$debit; echo "<br>";
        echo "credit: ".$credit; echo "<br><br>";
        echo "amount: ".$amount; echo "<br>";
        echo "trans_action: ".$trans_action; echo "<br>";
        die;*/
            
        $order_id = 0;
        CustomerTransaction::update_customer_transaction($trans_id, $user_id, $customer_id, $order_id, $description, $attachment_path, $amount, $trans_action, $status);

        //edit log
        $customer_transaction_log = new CustomerTransactionLog();
        $customer_transaction_log->transaction_id = $trans_id;
        $customer_transaction_log->user_id = $user_id;
        $customer_transaction_log->amount = $amount;
        $customer_transaction_log->save();
        $transaction_edit_log = "Transaction edited -> trans_id: {$trans_id}, user_id: {$user_id}, amount: {$amount}";
        Log::channel('transaction_edit_log')->info($transaction_edit_log);
         //edit log end



        

        return Redirect::to('admin/customer-transactions?customer_id='.$customer_id)->with('success','Transaction Recored updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //Customer $customer
    {   

        $customer_transaction = CustomerTransaction::where('id', $id)->first();
        $customer_id = $customer_transaction->customer_id;
        $customer_transaction->delete();

        //update balance after deletion
        CustomerBalance::update_customer_balance_after_delete($customer_id);

        return Redirect::to('admin/customer-transactions?customer_id='.$customer_id)->with('success','Transactions deleted successfully');
    }
}
