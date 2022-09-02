<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Group;
use App\Models\Bc;
use App\Models\MemberBcPlan;
use Illuminate\Http\Request;

class BcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bcs = Bc::with('group')->orderBy('id', 'DESC')->paginate(10);
        return view('bcs.index', compact('bcs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $groups = Group::all();
        return view('bcs.create', ['groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required'
        ]);

        //
        $member_count = Member::where('group_id', $request->group_id)->count();
        $total_grosss_amount = $request->gross_amount - $request->loss_amount;
        $total_bc_amount =  $total_grosss_amount / $member_count;
        $calculate_commision_amount = ( $total_bc_amount * $request->commission_amount ) / 100;
        $emi_amount = $total_bc_amount + $calculate_commision_amount;
        //

        $bc = new Bc();
        $bc->group_id = $request->group_id;
        $bc->title = $request->title;
        $bc->gross_amount = $request->gross_amount;
        $bc->loss_amount = $request->loss_amount;
        $bc->commission_amount = $request->commission_amount;
        $bc->total_bc_amount = $emi_amount; //$request->total_bc_amount;
        $bc->save();
        return redirect()->route('bcs.index')->with('success','Bc added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bc  $bc
     * @return \Illuminate\Http\Response
     */
    public function show(Bc $bc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bc  $bc
     * @return \Illuminate\Http\Response
     */
    public function edit(Bc $bc)
    {   
        $groups = Group::all();
        return view('bcs.edit', ['bc' => $bc, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bc  $bc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bc $bc)
    {
        $request->validate([
            'group_id' => 'required'
        ]);

        //
        $member_count = Member::where('group_id', $request->group_id)->count();
        $total_grosss_amount = $request->gross_amount - $request->loss_amount;
        $total_bc_amount =  $total_grosss_amount / $member_count;
        $calculate_commision_amount = ( $total_bc_amount * $request->commission_amount ) / 100;
        $emi_amount = $total_bc_amount + $calculate_commision_amount;
        //

        $bc->group_id = $request->group_id;
        $bc->title = $request->title;
        $bc->gross_amount = $request->gross_amount;
        $bc->loss_amount = $request->loss_amount;
        $bc->commission_amount = $request->commission_amount;
        $bc->total_bc_amount = $emi_amount; //$request->total_bc_amount;
        $bc->update();
        
        return redirect()->route('bcs.index')->with('success','Bc updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bc  $bc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bc $bc)
    {
        $bc->delete();
        return redirect()->route('bcs.index')->with('success','Bc deleted successfully');
    }
}
