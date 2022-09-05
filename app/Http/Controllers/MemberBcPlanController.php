<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Group;
use App\Models\Bc;
use App\Models\MemberBcPlan;
use Illuminate\Http\Request;

class MemberBcPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberBcPlans = MemberBcPlan::with(['group', 'member', 'bc'])->orderBy('id', 'DESC')->paginate(10);
        return view('member-bc-plans.index', compact('memberBcPlans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $members = Member::all();
        $groups = Group::all();
        $bcs = Bc::all();
        return view('member-bc-plans.create', ['members' => $members, 'groups' => $groups, 'bcs' => $bcs]);
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
        $bc = Bc::where('id', $request->bc_id)->first();
        $total_bc_amount = $bc->total_bc_amount;
        $members = Member::where('group_id', $request->group_id)->get();
        foreach ($members as $member) {
           
            //Check if already exist
            $MemberBcPlan = MemberBcPlan::where(['member_id' => $member->id, 'bc_id' => $request->bc_id])->first();
            if (!is_object($MemberBcPlan)) {
                $memberBcPlan = new MemberBcPlan();
                $memberBcPlan->group_id = $request->group_id;
                $memberBcPlan->member_id = $member->id;
                $memberBcPlan->bc_id = $request->bc_id;
                $memberBcPlan->emi_amount = $total_bc_amount; //$request->emi_amount; 
                $memberBcPlan->save();
            }

        }
        //

        /*$memberBcPlan = new MemberBcPlan();
        $memberBcPlan->group_id = $request->group_id;
        $memberBcPlan->member_id = $request->member_id;
        $memberBcPlan->bc_id = $request->bc_id;
        $memberBcPlan->emi_amount = $request->emi_amount;
        $memberBcPlan->save();*/
        return redirect()->route('member-bc-plans.index')->with('success','Bc Plan added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberBcPlan  $memberBcPlan
     * @return \Illuminate\Http\Response
     */
    public function show(MemberBcPlan $memberBcPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MemberBcPlan  $memberBcPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(MemberBcPlan $memberBcPlan)
    {   
        $members = Member::all();
        $groups = Group::all();
        $bcs = Bc::all();
        return view('member-bc-plans.edit', ['memberBcPlan' => $memberBcPlan, 'members' => $members, 'groups' => $groups, 'bcs' => $bcs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberBcPlan  $memberBcPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberBcPlan $memberBcPlan)
    {
        $request->validate([
            'group_id' => 'required'
        ]);

        //
        $bc = Bc::where('id', $request->bc_id)->first();
        $total_bc_amount = $bc->total_bc_amount;
        $members = Member::where('group_id', $request->group_id)->get();
        foreach ($members as $member) {

            //Check if already exist
            $MemberBcPlan = MemberBcPlan::where(['member_id' => $member->id, 'bc_id' => $request->bc_id])->first();
            if (!is_object($MemberBcPlan)) {
                $memberBcPlan->group_id = $request->group_id;
                $memberBcPlan->member_id = $member->id;
                $memberBcPlan->bc_id = $request->bc_id;
                $memberBcPlan->emi_amount = $total_bc_amount; //$request->emi_amount; 
                $memberBcPlan->update();
            }

            /*$memberBcPlan->group_id = $request->group_id;
            $memberBcPlan->member_id = $member->id;
            $memberBcPlan->bc_id = $request->bc_id;
            $memberBcPlan->emi_amount = $total_bc_amount; //$request->emi_amount; 
            $memberBcPlan->update();*/
        }
        //

        /*$memberBcPlan->group_id = $request->group_id;
        $memberBcPlan->member_id = $request->member_id;
        $memberBcPlan->bc_id = $request->bc_id;
        $memberBcPlan->emi_amount = $request->emi_amount;
        $memberBcPlan->update();*/
        return redirect()->route('member-bc-plans.index')->with('success','Bc Plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberBcPlan  $memberBcPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberBcPlan $memberBcPlan)
    {
        $memberBcPlan->delete();
        return redirect()->route('member-bc-plans.index')->with('success','Bc Plan deleted successfully');
    }
}
