<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Group;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::with('group')->orderBy('id', 'DESC')->paginate(10);
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        return view('members.create', ['groups' => $groups]);
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
            'name' => 'required'
        ]);

        $member = new Member();
        $member->name = $request->name;
        $member->email = $request->email;
        $member->mobile = $request->mobile;
        $member->address = $request->address;
        $member->group_id = $request->group_id;
        $member->save();
        return redirect()->route('members.index')->with('success','Member added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {   
        $groups = Group::all();
        return view('members.edit', ['member' => $member, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $member->name = $request->name;
        $member->email = $request->email;
        $member->mobile = $request->mobile;
        $member->address = $request->address;
        $member->group_id = $request->group_id;
        $member->update();
        return redirect()->route('members.index')->with('success','Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success','Member deleted successfully');
    }
}
