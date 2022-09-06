<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Member;
use App\Models\MemberBcPlan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['member'])->orderBy('id', 'DESC')->paginate(10);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::all();
        return view('payments.create', ['members' => $members]);
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
            'member_id' => 'required',
            'member_bc_plan_id' => 'required',
            'paid_emi_amount' => 'required'
        ]);

        $payment = new Payment();
        $payment->member_id = $request->member_id;
        $payment->member_bc_plan_id = $request->member_bc_plan_id;
        $payment->paid_emi_amount = $request->paid_emi_amount;
        $payment->emi_payment_status = '';//$request->emi_payment_status;
        $payment->save();
        return redirect()->route('payments.index')->with('success','Payment added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $members = Member::all();
        return view('payments.edit', ['payment' => $payment, 'members' => $members]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'member_id' => 'required',
            'member_bc_plan_id' => 'required',
            'paid_emi_amount' => 'required'
        ]);

        $payment->member_id = $request->member_id;
        $payment->member_bc_plan_id = $request->member_bc_plan_id;
        $payment->paid_emi_amount = $request->paid_emi_amount;
        $payment->emi_payment_status = '';//$request->emi_payment_status;
        $payment->update();

        return redirect()->route('payments.index')->with('success','Payment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success','Payment deleted successfully');
    }
}
