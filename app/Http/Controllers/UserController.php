<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if ( !empty($_GET['s']) && empty($_GET['user_type'])) { //echo "string1";
            $users = User::query()
            ->where('name', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('email', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('mobile', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('mobile_alternate', 'LIKE', '%'.$_GET['s'].'%')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else if( empty($_GET['s']) && !empty($_GET['user_type']) ){ //echo "string2";
            $users = User::query()
            ->where('user_type', $_GET['user_type'])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else if( !empty($_GET['s']) && !empty($_GET['user_type']) ){ //echo "string3";
            $users = User::query()
            ->where('name', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('email', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('mobile', 'LIKE', '%'.$_GET['s'].'%')
            ->orWhere('mobile_alternate', 'LIKE', '%'.$_GET['s'].'%')
            ->where('user_type', $_GET['user_type'])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        }else{
           $users = User::orderBy('id', 'DESC')->paginate(10);
        }
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'name' => 'required',
            'email' => 'required',
            'user_type' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->user_type = 'administrator'; //$request->user_type;
       /* $user->mobile = $request->mobile;
        $user->mobile_alternate = $request->mobile_alternate;*/
        $user->save();
        return redirect()->route('users.index')->with('success','User added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user_id = auth()->user()->id;
        return view('users.edit', ['user_id' => $user_id, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'user_type' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        //$user->password = $request->password;
        $user->user_type = 'administrator'; //$request->user_type;
        /*$user->mobile = $request->mobile;
        $user->mobile_alternate = $request->mobile_alternate;*/
        $user->update();
        return redirect()->route('users.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','user deleted successfully');
    }

    public function destroy_bulk(Request $request)
    {
        $entity_ids = $request->entity_ids;
        $entity_ids = explode(",", $entity_ids);
        //echo "<pre>-->"; print_r($entity_ids); echo "</pre>"; die;
        User::whereIn('id', $entity_ids)->delete();
        return redirect()->route('products.index')->with('success','Bulk Product deleted successfully');
    }
}
