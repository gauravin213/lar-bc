<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTransaction extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public static function create_customer_transaction($user_id, $customer_id, $order_id = 0, $description = '', $attachment_path = '', $amount, $transaction_type, $status='successful')
    {
        $customer_transaction = new CustomerTransaction();
        $customer_transaction->user_id  = $user_id;
        $customer_transaction->customer_id  = $customer_id;
        $customer_transaction->order_id  = $order_id;
        $customer_transaction->description = $description;
        $customer_transaction->attachment = $attachment_path;

        $customer_total_balance = CustomerBalance::get_customer_total_balance($customer_id);
        $total_debit = $customer_total_balance['total_debit'];
        $total_credit = $customer_total_balance['total_credit'];

        //$total_debit = CustomerTransaction::where('customer_id', $customer_id)->sum('debit');
        //$total_credit = CustomerTransaction::where('customer_id', $customer_id)->sum('credit');

        if ($transaction_type == 'debit') {

            $customer_transaction->debit = $amount;

            $total_debit  =  $total_debit + $amount;

            if ($total_debit > $total_credit) {  
                $balance = ( $total_debit - $total_credit );
                $customer_transaction->balance = $balance;
                $_transaction_type = ($balance!=0) ? 'dr' : 'setteled';
                $customer_transaction->transaction_type = $_transaction_type;
            }else{ 
                $balance = ( $total_credit - $total_debit );
                $customer_transaction->balance = $balance;
                $_transaction_type = ($balance!=0) ? 'cr' : 'setteled';
                $customer_transaction->transaction_type = $_transaction_type;
            } 

           $customer_transaction->status = $status; //failed pending successful
            if ($status == 'successful') {
                CustomerBalance::update_customer_balance($customer_id, $total_debit, $total_credit, $balance, $_transaction_type);
            }
            
        }

        if ($transaction_type == 'credit') {

            $customer_transaction->credit = $amount;

            $total_credit = $total_credit + $amount;

            if ($total_debit > $total_credit) {
                $balance = ( $total_debit - $total_credit );
                $customer_transaction->balance = $balance;
                $_transaction_type = ($balance!=0) ? 'dr' : 'setteled';
                $customer_transaction->transaction_type = $_transaction_type;
            }else{
                $balance = ( $total_credit - $total_debit );
                $customer_transaction->balance = $balance;
                $_transaction_type = ($balance!=0) ? 'cr' : 'setteled';
                $customer_transaction->transaction_type = $_transaction_type;
            }

            $customer_transaction->status = $status; //failed pending successful
            if ($status == 'successful') {
                CustomerBalance::update_customer_balance($customer_id, $total_debit, $total_credit, $balance, $_transaction_type);
            }
            
        }

        $customer_transaction->save();
    }

    public static function update_customer_transaction($trans_id, $user_id, $customer_id, $order_id = '', $description = '', $attachment_path = '', $amount, $transaction_type, $status='successful')
    {
        $customer_transaction = CustomerTransaction::where('id', $trans_id)->first();
        $customer_transaction->user_id  = $user_id;
        $customer_transaction->customer_id  = $customer_id;
        $customer_transaction->order_id  = $order_id;
        $customer_transaction->description = $description;
        $customer_transaction->attachment = $attachment_path;
        $debit = $customer_transaction->debit;
        $credit = $customer_transaction->credit;
        //$_transaction_type = $customer_transaction->transaction_type;

        $customer_total_balance = CustomerBalance::get_customer_total_balance($customer_id);
        if (!empty($debit)) {
            $action_amount = $debit;
            $total_debit = $customer_total_balance['total_debit'] - $action_amount;
            $total_credit = $customer_total_balance['total_credit'];
        }else{
            $action_amount = $credit;
            $total_debit = $customer_total_balance['total_debit'];
            $total_credit = $customer_total_balance['total_credit'] - $action_amount;
        }
        
        //$total_debit = CustomerTransaction::where('customer_id', $customer_id)->where('id', '!=' , $trans_id)->sum('debit');
        //$total_credit = CustomerTransaction::where('customer_id', $customer_id)->where('id', '!=' , $trans_id)->sum('credit');
        //echo "action_amount: ".$action_amount; echo "<br>";
        //echo "total_debit: ".$total_debit; echo "<br>";
        //echo "total_credit: ".$total_credit; echo "<br>"; die;

        if ($transaction_type == 'debit') {

            $customer_transaction->debit = $amount;

            $total_debit  =  $total_debit + $amount;

            if ($total_debit > $total_credit) {  
                $balance = ( $total_debit - $total_credit );
                $customer_transaction->balance = $balance;
                $_transaction_type = ($balance!=0) ? 'dr' : 'setteled';
                $customer_transaction->transaction_type = $_transaction_type;
            }else{ 
                $balance = ( $total_credit - $total_debit );
                $customer_transaction->balance = $balance;
                $_transaction_type = ($balance!=0) ? 'cr' : 'setteled';
                $customer_transaction->transaction_type = $_transaction_type;
            } 

            $customer_transaction->status = $status; //failed pending successful
            CustomerBalance::update_customer_balance($customer_id, $total_debit, $total_credit, $balance, $_transaction_type);
            
        }

        if ($transaction_type == 'credit') {

            $customer_transaction->credit = $amount;

            $total_credit = $total_credit + $amount;

            if ($total_debit > $total_credit) {
                $balance = ( $total_debit - $total_credit );
                $customer_transaction->balance = $balance;
                $_transaction_type = ($balance!=0) ? 'dr' : 'setteled';
                $customer_transaction->transaction_type = $_transaction_type;
            }else{
                $balance = ( $total_credit - $total_debit );
                $customer_transaction->balance = $balance;
                $_transaction_type = ($balance!=0) ? 'cr' : 'setteled';
                $customer_transaction->transaction_type = $_transaction_type;
            }

            $customer_transaction->status = $status; //failed pending successful
            CustomerBalance::update_customer_balance($customer_id, $total_debit, $total_credit, $balance, $_transaction_type);
            
        }

        $customer_transaction->update();
    }
}


//failed pending successful