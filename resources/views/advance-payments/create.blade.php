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
        <h3 class="card-title">Add Payment</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form action="{{ route('advance-payments.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Party Name</label>
            <select name="customer_id" class="form-control" id="customer_id">
              <option value="">select</option>
              @foreach($customers as $customer)
              <option value="{{$customer->id}}">{{$customer->name}}({{$customer->company_name}})</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Amount</label>
            <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter amount">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Mode Of Payment</label>
            <select name="mode_of_payment" class="form-control" id="mode_of_payment">
              <option value="">select</option>
              <option value="Cash">Cash</option>
              <option value="Cheque">Cheque</option>
              <option value="RTGS">RTGS</option>
              <option value="NEFT">NEFT</option>
              <option value="IMPS">IMPS</option>
              <option value="DD">DD</option>
              <option value="UPI">UPI</option>              
            </select>
          </div>

           <div class="form-group">
            <label for="exampleInputEmail1">Upload Receipt</label>
            <input type="file" name="upload_receipt" class="form-control preview_img" id="upload_receipt" accept="image/*">
            <img src="" id="pan_no_img" style="width: 20%;" />
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remark/Note</label>
            <textarea name="remark" class="form-control" id="remark" placeholder="Specify Cheque Date/Transaction ID Of Payment"></textarea>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Payment Date</label>
            <input type="text" name="payment_date" class="form-control" id="payment_date" autocomplete="off" value="">
          </div>

          <input type="hidden" name="placed_by" class="form-control" id="placed_by" placeholder="Enter placed_by" value="{{$user_id}}">

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