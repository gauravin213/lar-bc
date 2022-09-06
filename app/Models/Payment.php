<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


	public function member()
	{
	    return $this->belongsTo(Member::class, 'member_id', 'id');
	}

	public function member_bc_plan()
	{
	    return $this->belongsTo(MemberBcPlan::class, 'member_bc_plan_id', 'id');
	}
}
