<?php

namespace App\Http\Controllers;

use App\Models\GroupBcRelation;
use Illuminate\Http\Request;

class GroupBcRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupBcRelations = GroupBcRelation::orderBy('id', 'DESC')->paginate(10);
        return view('group-bc-relations.index', compact('groupBcRelations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group-bc-relations.create');
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

        $groupBcRelation = new GroupBcRelation();
        $groupBcRelation->group_id = $request->group_id;
        $groupBcRelation->bc_id = $request->bc_id;
        $groupBcRelation->save();
        return redirect()->route('group-bc-relations.index')->with('success','Applied successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GroupBcRelation  $groupBcRelation
     * @return \Illuminate\Http\Response
     */
    public function show(GroupBcRelation $groupBcRelation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GroupBcRelation  $groupBcRelation
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupBcRelation $groupBcRelation)
    {
        return view('group-bc-relations.edit', ['groupBcRelation' => $groupBcRelation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GroupBcRelation  $groupBcRelation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupBcRelation $groupBcRelation)
    {
        $request->validate([
            'group_id' => 'required'
        ]);

        $groupBcRelation->group_id = $request->group_id;
        $groupBcRelation->bc_id = $request->bc_id;
        $groupBcRelation->update();
        return redirect()->route('group-bc-relations.index')->with('success','Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GroupBcRelation  $groupBcRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(GroupBcRelation $groupBcRelation)
    {
        $groupBcRelation->delete();
        return redirect()->route('group-bc-relations.index')->with('success','GroupBcRelation deleted successfully');
    }
}
