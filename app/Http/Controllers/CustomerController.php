<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerTransaction;
use App\Models\CustomerBalance;

use File;
use Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
    
        $user_id = auth()->user()->id;
        $user_type = auth()->user()->user_type;
        $users = User::where('user_type', 'sales_man')->get();

        //sales_persone_id

        if ($user_type == 'administrator') {

            if ( !empty($_GET['s']) && empty($_GET['sales_persone_id']) ) {  //echo "string1";

                $customers = Customer::query()
                ->with('user')
                ->where('name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('company_name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('credit_limit', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('address', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('mobile', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('email', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('pan_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('aadhar_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('gst_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            }else if( empty($_GET['s']) && !empty($_GET['sales_persone_id']) ){ //echo "string2";

                $customers = Customer::query()
                ->with('user')
                ->where('sales_persone_id', $_GET['sales_persone_id'])
                ->orderBy('id', 'DESC')
                ->paginate(10);

            }else if( !empty($_GET['s']) && !empty($_GET['sales_persone_id'])){ //echo "string3";

                $customers = Customer::query()
                ->with('user')
                ->where('sales_persone_id', $_GET['sales_persone_id'])
                ->orWhere('name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('company_name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('credit_limit', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('address', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('mobile', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('email', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('pan_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('aadhar_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('gst_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            }else{
                $customers = Customer::with('user')->orderBy('id', 'DESC')->paginate(10);
            }
        }else{
             if ( !empty($_GET['s']) && empty($_GET['sales_persone_id']) ) {
                $customers = Customer::query()
                ->with('user')
                ->where('sales_persone_id', $user_id)
                ->orWhere('name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('company_name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('credit_limit', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('address', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('mobile', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('email', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('pan_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('aadhar_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('gst_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orderBy('id', 'DESC')
                ->paginate(10);
            }else if( empty($_GET['s']) && !empty($_GET['sales_persone_id']) ){

                $customers = Customer::query()
                ->with('user')
                ->where('sales_persone_id', $_GET['sales_persone_id'])
                ->orderBy('id', 'DESC')
                ->paginate(10);

            }else if( !empty($_GET['s']) && !empty($_GET['sales_persone_id'])){

                $customers = Customer::query()
                ->with('user')
                ->where('sales_persone_id', $_GET['sales_persone_id'])
                ->orWhere('name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('company_name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('credit_limit', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('address', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('mobile', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('email', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('pan_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('aadhar_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('gst_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            }else{
                $customers = Customer::with('user')->where('sales_persone_id', $user_id)->orderBy('id', 'DESC')->paginate(10);
            }
            
        }

        //users


        //
       /* $ppppp = Customer::with(['user', 'orders'])->where('id', 85)->orderBy('id', 'DESC')->first();
        //dd($ppppp);

        $customer_order_array = [];
        if (!empty($ppppp)) {

            if (!empty($ppppp->orders)) {

                foreach ($ppppp->orders as $order) {

                    //echo "order: ".$order->id; echo "<br>";
                    $customer_order_array[$order->id]['customer_id'] = $ppppp->id;
                    $customer_order_array[$order->id]['customer_name'] = $ppppp->name;
                    $customer_order_array[$order->id]['order_id'] = $order->id;
                    $customer_order_array[$order->id]['order_total'] = $order->total;

                    if (!empty($order->items)) {
                        
                        foreach ($order->items as $item) {
                            //echo "item: ".$item->id; echo "<br>";
                            $customer_order_array[$order->id]['items'][] = $item->name;
                        }

                    }

                    $received_amount = [];
                    $balance_amount = [];
                    if (!empty($order->transaction)) {
                        foreach ($order->transaction as $transaction) {
                            //echo "transaction: ".$transaction->id; echo "<br>";
                            $customer_order_array[$order->id]['transaction'][] = $transaction->paid_amount;
                            $received_amount[] = $transaction->paid_amount;
                            $balance_amount[] = $transaction->ballance_amount;
                        }
                    }
                    $customer_order_array[$order->id]['received_amount'][] = array_sum($received_amount);
                    //$customer_order_array[$order->id]['balance_amount'][] = array_sum($balance_amount);; //$order->balance_amount;
                    $customer_order_array[$order->id]['balance_amount'][] = $order->balance_amount;


                }
               
            }

            
        }
        echo "<pre>"; print_r($customer_order_array); echo "</pre>";*/
        //


        //Balance report
        $total_debit = CustomerBalance::sum('total_debit');
        $total_credit = CustomerBalance::sum('total_credit');
        $total_balance = CustomerBalance::sum('total_balance');
        $balance_report = [];
        if ($total_debit > $total_credit) {
            //you will get
            $balance_report= [
                'class' => 'red',
                'label' => 'you will get',
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'total_balance' => $total_balance
            ];

        }else if($total_debit < $total_credit){
            //you will give
            $balance_report= [
                'class' => 'green',
                'label' => 'you will give',
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'total_balance' => $total_balance
            ];
        }else{
            //setteled
            $balance_report= [
                'class' => '',
                'label' => 'setteled',
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'total_balance' => $total_balance
            ];
        }

        //echo "<pre>"; print_r($balance_report); echo "</pre>"; die;
        //Balance report end

        return view('customers.index', ['customers' => $customers, 'users' => $users, 'user_type' => $user_type, 'balance_report' => $balance_report]);
    }

    public function exportcsv(Request $request)
    {      

        $data = $request->all();

        $user_id = auth()->user()->id;
        $user_type = auth()->user()->user_type;

        if ($user_type == 'administrator') {
            if ( isset($_GET['s']) && $_GET['s'] !='') {
                $customers = Customer::query()
                ->with('user')
                ->where('name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('company_name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('credit_limit', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('address', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('mobile', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('email', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('pan_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('aadhar_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('gst_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orderBy('id', 'DESC')
                ->get();
            }else{
                $customers = Customer::with('user')->orderBy('id', 'DESC')->get();
            }
        }else{
            if ( isset($_GET['s']) && $_GET['s'] !='') {
                $customers = Customer::query()
                ->with('user')
                ->where('sales_persone_id', $user_id)
                ->orWhere('name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('company_name', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('credit_limit', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('address', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('mobile', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('email', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('pan_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('aadhar_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orWhere('gst_no', 'LIKE', '%'.$_GET['s'].'%')
                ->orderBy('id', 'DESC')
                ->get();
            }else{
                $customers = Customer::with('user')->where('sales_persone_id', $user_id)->orderBy('id', 'DESC')->get();
            }
        }

        // these are the headers for the csv file.
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=customers-download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );


        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        //creating the download file
        $filename =  public_path("files/customers-download.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
            "ID",
            "Name",
            "Company Name",
            "Credit Limit",
            "Address",
            "Mobile",
            "Email",
            "Profile_image",
            "Pan No.",
            "Pan Front Img",
            "Pan Back Img",
            "Aadhar No.",
            "Aadhar Front Img",
            "Aadhar Back Img",
            "Gst No.",
            "Gst Front Img",
            "Gst Back Img",
            "Gst Third Img",
            "Sales Persone Id"
        ]);

        //adding the data from the array
        foreach ($customers as $customer) {

            $sales_persone_id = (is_object($customer->user)) ? $customer->user->name : 'N/A';

            fputcsv($handle, [
                $customer->id,
                $customer->name,
                $customer->company_name,
                $customer->credit_limit,
                $customer->address,
                $customer->mobile,
                $customer->email,
                $customer->profile_image,
                $customer->pan_no,
                $customer->pan_no_front_img,
                $customer->pan_no_back_img,
                $customer->aadhar_no,
                $customer->aadhar_no_front_img,
                $customer->aadhar_no_back_img,
                $customer->gst_no,
                $customer->gst_no_front_img,
                $customer->gst_no_back_img,
                $customer->gst_no_third_img,
                $sales_persone_id
            ]);

        }
        fclose($handle);

        //download command
        return Response::download($filename, "customers-download.csv", $headers);

        //end export
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $user_type = auth()->user()->user_type;

        if ($user_type == 'administrator') {
            $salesmans = User::all();
        }else{
           $salesmans = User::where('user_type', $user_type)->get();
        }

        //dd($salesmans);
        return view('customers.create', ['user_id' => $user_id, 'user_type'=>$user_type, 'salesmans' =>$salesmans]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //$data = $request->all();
        //echo "<pre>"; print_r($data); echo "</pre>"; die;

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            //'email' => 'required',
            'pan_no' => 'required',
            //'aadhar_no' => 'required',
            //'gst_no' => 'required',
        ]);


        $customer = new Customer();
        $customer->name = $request->name;
        $customer->company_name = $request->company_name;
        $customer->credit_limit = $request->credit_limit;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->mobile_alternate = $request->mobile_alternate;
        $customer->email = $request->email;
        $customer->pan_no = $request->pan_no;
        $customer->aadhar_no = $request->aadhar_no;
        $customer->gst_no = $request->gst_no;

        if ($request->profile_image) {
            $profile_image = $request->file('profile_image')->getClientOriginalName();
            $profile_image_path = $request->file('profile_image')->store('uploads');
            $customer->profile_image = $profile_image_path;
        }

        if ($request->pan_no_front_img) {
            $pan_no_front_img = $request->file('pan_no_front_img')->getClientOriginalName();
            $pan_no_front_img_path = $request->file('pan_no_front_img')->store('uploads');
            $customer->pan_no_front_img = $pan_no_front_img_path;
         
        }
        if ($request->pan_no_back_img) {
            $pan_no_back_img = $request->file('pan_no_back_img')->getClientOriginalName();
            $pan_no_back_img_path = $request->file('pan_no_back_img')->store('uploads');
            $customer->pan_no_back_img = $pan_no_back_img_path;
        }


        if ($request->aadhar_no_front_img) {
            $aadhar_no_front_img = $request->file('aadhar_no_front_img')->getClientOriginalName();
            $aadhar_no_front_img_path = $request->file('aadhar_no_front_img')->store('uploads');
            $customer->aadhar_no_front_img = $aadhar_no_front_img_path;
        }
        if ($request->aadhar_no_back_img) {
            $aadhar_no_back_img = $request->file('aadhar_no_back_img')->getClientOriginalName();
            $aadhar_no_back_img_path = $request->file('aadhar_no_back_img')->store('uploads');
            $customer->aadhar_no_back_img = $aadhar_no_back_img_path;
        }


        if ($request->gst_no_front_img) {
            $gst_no_front_img = $request->file('gst_no_front_img')->getClientOriginalName();
            $gst_no_front_img_path = $request->file('gst_no_front_img')->store('uploads');
            $customer->gst_no_front_img = $gst_no_front_img_path;
        }
        if ($request->gst_no_back_img ) {
            $gst_no_back_img = $request->file('gst_no_back_img')->getClientOriginalName();
            $gst_no_back_img_path = $request->file('gst_no_back_img')->store('uploads');
            $customer->gst_no_back_img = $gst_no_back_img_path;
        }
        if ($request->gst_no_third_img) {
            $gst_no_third_img = $request->file('gst_no_third_img')->getClientOriginalName();
            $gst_no_third_img_path = $request->file('gst_no_third_img')->store('uploads');
            $customer->gst_no_third_img = $gst_no_third_img_path;
        }

        $customer->sales_persone_id = $request->sales_persone_id;
        $customer->save();
        return redirect()->route('customers.index')->with('success','Customer added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $customer = Customer::with('user')->find($customer->id);
        $crr_user = auth()->user();
        return view('customers.show', ['crr_user'=>$crr_user, 'customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $user_id = auth()->user()->id;
        $user_type = auth()->user()->user_type;
        if ($user_type == 'administrator') {
            $salesmans = User::all();
        }else{
           $salesmans = User::where('user_type', $user_type)->get();
        }
        return view('customers.edit', ['user_id' => $user_id, 'customer' => $customer, 'user_type'=>$user_type, 'salesmans' => $salesmans]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //$fileName = time().'.'.$request->file->extension();  
        //$request->file->move(public_path('uploads'), $fileName);

        //$data = $request->all();
        //echo "<pre>"; print_r($data); echo "</pre>"; die;

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            //'email' => 'required',
            'pan_no' => 'required',
            //'aadhar_no' => 'required',
            //'gst_no' => 'required',
        ]);
        
        $customer->name = $request->name;
        $customer->company_name = $request->company_name;
        $customer->credit_limit = $request->credit_limit;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->mobile_alternate = $request->mobile_alternate;
        $customer->email = $request->email;
        $customer->pan_no = $request->pan_no;
        $customer->aadhar_no = $request->aadhar_no;
        $customer->gst_no = $request->gst_no;

         if ($request->profile_image) {
            $profile_image = $request->file('profile_image')->getClientOriginalName();
            $profile_image_path = $request->file('profile_image')->store('uploads');
            $customer->profile_image = $profile_image_path;
        }

        if ($request->pan_no_front_img) {
            $pan_no_front_img = $request->file('pan_no_front_img')->getClientOriginalName();
            $pan_no_front_img_path = $request->file('pan_no_front_img')->store('uploads');
            $customer->pan_no_front_img = $pan_no_front_img_path;
         
        }
        if ($request->pan_no_back_img) {
            $pan_no_back_img = $request->file('pan_no_back_img')->getClientOriginalName();
            $pan_no_back_img_path = $request->file('pan_no_back_img')->store('uploads');
            $customer->pan_no_back_img = $pan_no_back_img_path;
        }


        if ($request->aadhar_no_front_img) {
            $aadhar_no_front_img = $request->file('aadhar_no_front_img')->getClientOriginalName();
            $aadhar_no_front_img_path = $request->file('aadhar_no_front_img')->store('uploads');
            $customer->aadhar_no_front_img = $aadhar_no_front_img_path;
        }
        if ($request->aadhar_no_back_img) {
            $aadhar_no_back_img = $request->file('aadhar_no_back_img')->getClientOriginalName();
            $aadhar_no_back_img_path = $request->file('aadhar_no_back_img')->store('uploads');
            $customer->aadhar_no_back_img = $aadhar_no_back_img_path;
        }


        if ($request->gst_no_front_img) {
            $gst_no_front_img = $request->file('gst_no_front_img')->getClientOriginalName();
            $gst_no_front_img_path = $request->file('gst_no_front_img')->store('uploads');
            $customer->gst_no_front_img = $gst_no_front_img_path;
        }
        if ($request->gst_no_back_img ) {
            $gst_no_back_img = $request->file('gst_no_back_img')->getClientOriginalName();
            $gst_no_back_img_path = $request->file('gst_no_back_img')->store('uploads');
            $customer->gst_no_back_img = $gst_no_back_img_path;
        }
        if ($request->gst_no_third_img) {
            $gst_no_third_img = $request->file('gst_no_third_img')->getClientOriginalName();
            $gst_no_third_img_path = $request->file('gst_no_third_img')->store('uploads');
            $customer->gst_no_third_img = $gst_no_third_img_path;
        }

        //$customer->sales_persone_id = $request->sales_persone_id;
        $customer->update();
        //return redirect()->route('customers.index')->with('success','Customer updated successfully');
        return redirect('admin/customers/'.$customer->id.'/edit')->with('success','Order added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success','Customer deleted successfully');
    }
}
