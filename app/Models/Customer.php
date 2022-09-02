<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function user()
	{
	    return $this->belongsTo(User::class, 'sales_persone_id', 'id');
	}

	public function orders()
	{
	    return $this->hasMany(Order::class, 'customer_id', 'id')->with(['items', 'transaction']);
	}
}
