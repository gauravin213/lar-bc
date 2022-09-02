<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /*public function customer()
	{
	    return $this->belongsTo(Customer::class, 'customer_id', 'id');
	}*/

	public function member()
	{
	    return $this->hasMany(Member::class, 'member_id', 'id');
	}
}
