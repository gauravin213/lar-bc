@extends('layouts.admin')

@section('content')
<div class="content-header"></div>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">

    @if ($message = Session::get('success'))
     <div class="alert alert-success">
      {{ $message }}
    </div>
    @endif

   @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Customer</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Total Fund: {{$customer->total_fund}}</label>
          </div>

         
          <div class="form-group">
            <label for="exampleInputEmail1">Client Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{$customer->name}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Company Name</label>
            <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Enter company name" value="{{$customer->company_name}}">
          </div>

          @if($user_type == 'administrator')
          <div class="form-group">
            <label for="exampleInputEmail1">Credit Limit</label>
            <input type="text" name="credit_limit" class="form-control" id="name" placeholder="Enter credit limit" value="{{$customer->credit_limit}}">
          </div>
          @endif

          <div class="form-group">
            <label for="exampleInputEmail1">Address Of Client</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="Enter address" value="{{$customer->address}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Mobile No.</label>
            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter mobile" value="{{$customer->mobile}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Alternate Mobile No.</label>
            <input type="text" name="mobile_alternate" class="form-control" id="mobile_alternate" placeholder="Enter Alternate Mobile No." value="{{$customer->mobile_alternate}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Enter name" value="{{$customer->email}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Photo Of Client</label>
            <input type="file" name="profile_image" class="form-control preview_img" id="profile_image" accept="image/*">
            @if ($customer->profile_image!='')
              <img src="{{url($customer->profile_image)}}" id="pan_no_img" style="width: 20%;" />
            @else
              <img src="" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>

         
          <div class="form-group">
             <label for="exampleInputEmail1">PAN Card No.</label>
             <input type="text" name="pan_no" class="form-control" id="pan_no" placeholder="Enter pan no" value="{{$customer->pan_no}}" onfocusout="ValidatePAN()">
             <span id="pan_no_error_msg" class="error" style="visibility: hidden;">Invalid PAN Number</span>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">PAN Card Front Image</label>
            <input type="file" name="pan_no_front_img" class="form-control preview_img" id="pan_no_front_img" accept="image/*">
            @if ($customer->pan_no_front_img!='')
              <img src="{{url($customer->pan_no_front_img)}}" id="pan_no_img" style="width: 20%;" />
             @else
              <img src="" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>
          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Pan Back Image</label>
            <input type="file" name="pan_no_back_img" class="form-control preview_img" id="pan_no_back_img" accept="image/*">
            @if ($customer->pan_no_back_img!='')
              <img src="{{url($customer->pan_no_back_img)}}" id="pan_no_img" style="width: 20%;" />
             @else
              <img src="" id="pan_no_img" style="width: 20%;" />
            @endif
          </div> -->

          <div class="form-group">
            <label for="exampleInputEmail1">Aadhar Card No.</label>
            <input type="text" name="aadhar_no" class="form-control" id="aadhar_no" placeholder="Enter aadhar no" value="{{$customer->aadhar_no}}" onfocusout="validateAadhaar()">
            <span id="aadhar_no_error_msg" class="error" style="visibility: hidden;">Invalid Aadhaar Number</span>
          </div>
           <div class="form-group">
            <label for="exampleInputEmail1">Aadhar Card Front Image</label>
            <input type="file" name="aadhar_no_front_img" class="form-control preview_img" id="aadhar_no_front_img" accept="image/*">
            @if ($customer->aadhar_no_front_img!='')
              <img src="{{url($customer->aadhar_no_front_img)}}" id="pan_no_img" style="width: 20%;" />
             @else
              <img src="" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Aadhar Card Back Image</label>
            <input type="file" name="aadhar_no_back_img" class="form-control preview_img" id="aadhar_no_back_img" accept="image/*">
            @if ($customer->aadhar_no_back_img!='')
              <img src="{{url($customer->aadhar_no_back_img)}}" id="pan_no_img" style="width: 20%;" />
             @else
              <img src="" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">GST No.</label>
            <input type="text" name="gst_no" class="form-control" id="gst_no" placeholder="Enter gst no" value="{{$customer->gst_no}}">
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">GST First Image</label>
            <input type="file" name="gst_no_front_img" class="form-control preview_img" id="gst_no_front_img" accept="image/*">
            @if ($customer->gst_no_front_img!='')
              <img src="{{url($customer->gst_no_front_img)}}" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Gst Second Image</label>
            <input type="file" name="gst_no_back_img" class="form-control preview_img" id="gst_no_back_img" accept="image/*">
            @if ($customer->gst_no_back_img!='')
              <img src="{{url($customer->gst_no_back_img)}}" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Gst Third Image</label>
            <input type="file" name="gst_no_third_img" class="form-control preview_img" id="gst_no_third_img" accept="image/*">
            @if ($customer->gst_no_third_img!='')
              <img src="{{url($customer->gst_no_third_img)}}" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>

        
          @if($user_type == 'administrator')
            <div class="form-group">
              <label for="exampleInputEmail1">Sales Person</label>
              <select name="sales_persone_id" class="form-control" id="sales_persone_id">
                <option value="">select</option>
                @foreach($salesmans as $salesman)
                  <option value="{{$salesman->id}}"  {{($salesman->id == $customer->sales_persone_id) ? 'selected' : ''}}>{{$salesman->name}}</option>
                @endforeach
              </select>
            </div>
          @else
          <div class="form-group" style="display: none;">
            <label for="exampleInputEmail1">Sales Persones</label>
            <input type="text" name="sales_persone_id" class="form-control" id="sales_persone_id" value="{{$user_id}}" value="{{$customer->sales_persone_id}}">
          </div>
          @endif

        
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection