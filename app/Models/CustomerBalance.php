<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBalance extends Model
{
    use HasFactory;

    /*
    * Add or update customer balance
    */
    public static function update_customer_balance($customer_id, $total_debit, $total_credit, $balance, $_transaction_type)
    {   
        $customer_balance  = CustomerBalance::where('customer_id',$customer_id)->first();
        if (!empty($customer_balance)) {
            //update
            $customer_balance->total_debit = $total_debit;
            $customer_balance->total_credit = $total_credit;
            $customer_balance->total_balance = $balance;
            $customer_balance->transaction_type = $_transaction_type;
            $customer_balance->update();
        }else{
            //Create
            $customer_balance = new CustomerBalance();
            $customer_balance->customer_id = $customer_id;
            $customer_balance->total_debit = $total_debit;
            $customer_balance->total_credit = $total_credit;
            $customer_balance->total_balance = $balance;
            $customer_balance->transaction_type = $_transaction_type;
            $customer_balance->save();
        }
    }

    /*
    * Get customer total balance
    */
    public static function get_customer_total_balance($customer_id)
    {
        $total_debit = 0;
        $total_credit = 0;
        $total_balance = 0;
        $transaction_type = '';
        $customer_balance  = CustomerBalance::where('customer_id', $customer_id)->first();
        if (!empty($customer_balance)) {
            $total_debit = $customer_balance->total_debit;
            $total_credit = $customer_balance->total_credit;
            $total_balance = $customer_balance->total_balance;
            $transaction_type = $customer_balance->transaction_type;
        }
        return [
            'total_debit' => $total_debit,
            'total_credit' => $total_credit,
            'total_balance' => $total_balance,
            'transaction_type' => $transaction_type
        ];
    }

    /*
    * Update customer balance after delete transaction
    */
    public static function update_customer_balance_after_delete($customer_id)
    {   
        //re-calculate
        $total_debit = CustomerTransaction::where('customer_id', $customer_id)->sum('debit');
        $total_credit = CustomerTransaction::where('customer_id', $customer_id)->sum('credit');

        /*echo "id: ".$id; echo "<br>";
        echo "customer_id: ".$customer_id; echo "<br>";
        echo "total_debit: ".$total_debit; echo "<br>";
        echo "total_credit: ".$total_credit; echo "<br>";
        die;*/

        if ($total_debit > $total_credit) {
            $total_balance = $total_debit - $total_credit;
            $transaction_type = ($total_balance !=0) ? 'dr' : 'setteled';
        }else{
            $total_balance = $total_credit - $total_debit;
            $transaction_type = ($total_balance !=0) ? 'cr' : 'setteled';
        }
        $customer_balance = CustomerBalance::where('customer_id', $customer_id)->first();
        $customer_balance->total_debit = $total_debit;
        $customer_balance->total_credit = $total_credit;
        $customer_balance->total_balance = $total_balance;
        $customer_balance->transaction_type = $transaction_type;
        $customer_balance->update();
        //re-calculate
    }
}
