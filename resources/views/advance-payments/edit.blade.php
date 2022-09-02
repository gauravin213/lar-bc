@extends('layouts.admin')

@section('content')
<div class="content-header"></div>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">

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
        <h3 class="card-title">Edit Payment</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
         <form action="{{ route('advance-payments.update', $advancePayment->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Party Name</label>
            <select name="customer_id" class="form-control" id="customer_id">
              <option value="">select</option>
              @foreach($customers as $customer)
              <option value="{{$customer->id}}" {{$customer->id == $advancePayment->customer_id  ? 'selected' : ''}}>{{$customer->name}}({{$customer->company_name}})</option>
              @endforeach
            </select>
          </div>


          <div class="form-group">
            <label for="exampleInputEmail1">Amount</label>
            <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter amount" value="{{$advancePayment->amount}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Mode Of Payment</label>
            <select name="mode_of_payment" class="form-control" id="mode_of_payment">
              <option value="" {{$advancePayment->mode_of_payment == ''  ? 'selected' : ''}}>select</option>
              <option value="Cash" {{$advancePayment->mode_of_payment == 'Cash'  ? 'selected' : ''}}>Cash</option>
              <option value="Cheque" {{$advancePayment->mode_of_payment == 'Cheque'  ? 'selected' : ''}}>Cheque</option>
              <option value="RTGS" {{$advancePayment->mode_of_payment == 'RTGS'  ? 'selected' : ''}}>RTGS</option>
              <option value="NEFT" {{$advancePayment->mode_of_payment == 'NEFT'  ? 'selected' : ''}}>NEFT</option>
              <option value="IMPS" {{$advancePayment->mode_of_payment == 'IMPS'  ? 'selected' : ''}}>IMPS</option>
              <option value="DD" {{$advancePayment->mode_of_payment == 'DD'  ? 'selected' : ''}}>DD</option>
              <option value="UPI" {{$advancePayment->mode_of_payment == 'UPI'  ? 'selected' : ''}}>UPI</option>              
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Upload Receipt</label>
            <input type="file" name="upload_receipt" class="form-control preview_img" id="upload_receipt" accept="image/*">
            @if ($advancePayment->upload_receipt!='')
              <img src="{{url($advancePayment->upload_receipt)}}" id="pan_no_img" style="width: 20%;" />
            @else
              <img src="" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remark/Note</label>
            <textarea name="remark" class="form-control" id="remark" placeholder="Specify Cheque Date/Transaction ID Of Payment">{{$advancePayment->remark}}</textarea>
          </div>

           <div class="form-group">
            <label for="exampleInputEmail1">Payment Date</label>
            <input type="text" name="payment_date" class="form-control" id="payment_date" autocomplete="off" value="{{date("d-m-Y", strtotime($advancePayment->payment_date))}}">
          </div>

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