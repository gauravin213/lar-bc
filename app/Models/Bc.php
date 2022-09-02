<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bc extends Model
{
    use HasFactory;

    public function memberBcPlan()
	{
	    return $this->hasMany(MemberBcPlan::class, 'bc_id', 'id');
	}

	public function group()
	{
	    return $this->belongsTo(Group::class, 'group_id', 'id');
	}
}
