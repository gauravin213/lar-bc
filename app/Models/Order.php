<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
	{
	    return $this->belongsTo(User::class, 'placed_by', 'id');
	}

	public function customer()
	{
	    return $this->belongsTo(Customer::class, 'customer_id', 'id');
	}

	public function items()
	{
	    return $this->hasMany(Orderitem::class, 'order_id', 'id');
	}

	public function transaction()
	{
	    return $this->hasMany(Transaction::class, 'order_id', 'id');
	}
}
