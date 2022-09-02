<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function order()
	{
	    return $this->belongsTo(Order::class, 'order_id', 'id');
	}

	public function customer()
	{
	    return $this->belongsTo(Customer::class, 'customer_id', 'id');
	}

	public function user()
	{
	    return $this->belongsTo(User::class, 'placed_by', 'id');
	}
}
