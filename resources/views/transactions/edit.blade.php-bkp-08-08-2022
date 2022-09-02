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
        <h3 class="card-title">Edit Transaction</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
         <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>

         
          <div class="form-group">
            <label for="exampleInputEmail1">Order Id</label>
            <input type="text" name="order_id" class="form-control" id="order_id" placeholder="Enter order_id" value="{{$transaction->order_id}}">
            <input type="hidden" name="customer_id" class="form-control" id="customer_id2" placeholder="Enter customer_id" value="{{$transaction->customer_id}}">
            <input type="hidden" name="placed_by" class="form-control" id="placed_by" placeholder="Enter placed_by" value="{{$transaction->placed_by}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Paid Amount</label>
            <input type="text" name="paid_amount" class="form-control" id="paid_amount" placeholder="Enter paid_amount" value="{{$transaction->paid_amount}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Ballance Amount</label>
            <input type="text" name="ballance_amount" class="form-control" id="ballance_amount" placeholder="Enter ballance_amount" value="{{$transaction->ballance_amount}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Mode Of Payment</label>
            <select name="mode_of_payment" class="form-control" id="mode_of_payment">
              <option value="" {{$transaction->mode_of_payment == ''  ? 'selected' : ''}}>select</option>
              <option value="Cash" {{$transaction->mode_of_payment == 'Cash'  ? 'selected' : ''}}>Cash</option>
              <option value="Cheque" {{$transaction->mode_of_payment == 'Cheque'  ? 'selected' : ''}}>Cheque</option>
              <option value="RTGS" {{$transaction->mode_of_payment == 'RTGS'  ? 'selected' : ''}}>RTGS</option>
              <option value="NEFT" {{$transaction->mode_of_payment == 'NEFT'  ? 'selected' : ''}}>NEFT</option>
              <option value="IMPS" {{$transaction->mode_of_payment == 'IMPS'  ? 'selected' : ''}}>IMPS</option>
              <option value="DD" {{$transaction->mode_of_payment == 'DD'  ? 'selected' : ''}}>DD</option>
              <option value="UPI" {{$transaction->mode_of_payment == 'UPI'  ? 'selected' : ''}}>UPI</option>              
            </select>
          </div>

      
          <div class="form-group">
            <label for="exampleInputEmail1">Upload Receipt</label>
            <input type="file" name="upload_receipt" class="form-control preview_img" id="upload_receipt" accept="image/*">
            @if ($transaction->upload_receipt!='')
              <img src="{{url($transaction->upload_receipt)}}" id="pan_no_img" style="width: 20%;" />
            @else
              <img src="" id="pan_no_img" style="width: 20%;" />
            @endif
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remark/Note</label>
            <textarea name="remark" class="form-control" id="remark" placeholder="Specify Cheque Date/Transaction ID Of Payment">{{$transaction->remark}}</textarea>
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