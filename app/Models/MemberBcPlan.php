<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBcPlan extends Model
{
    use HasFactory;

	public function group()
	{
	    return $this->belongsTo(Group::class, 'group_id', 'id');
	}

	public function member()
	{
	    return $this->belongsTo(Member::class, 'member_id', 'id');
	}

	public function bc()
	{
	    return $this->belongsTo(Bc::class, 'bc_id', 'id');
	}
}
