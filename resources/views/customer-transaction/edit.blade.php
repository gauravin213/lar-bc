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
        <form action="{{ route('customer-transactions.update', $customer_transaction->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        
         <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Status</label>
             <select name="status" class="form-control" id="status">
              <option value="">select</option>
              <option value="failed" {{$customer_transaction->status == 'failed'  ? 'selected' : ''}}>failed</option>
              <option value="pending" {{$customer_transaction->status == 'pending'  ? 'selected' : ''}}>pending</option>
              <option value="successful" {{$customer_transaction->status == 'successful'  ? 'selected' : ''}}>successful</option>
            </select>
          </div>
         
          <div class="form-group">
            <label for="exampleInputEmail1">Amount {{$customer_transaction->transaction_type}}</label>
            <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter amount" value="{{ $amount }}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description" value="{{$customer_transaction->description}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Attachment</label>
            @if ($customer_transaction->attachment!='')
              <img src="{{url($customer_transaction->attachment)}}" id="pan_no_img" style="width: 20px;" />
            @else
              <img src="" id="pan_no_img" style="width: 20px;" />
            @endif
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <!-- <button type="submit" class="btn btn-danger" name="transaction_type" value="debit">Debit</button>
          <button type="submit" class="btn btn-success" name="transaction_type" value="credit">Credit</button> -->
          <button type="submit" class="btn btn-primary">Update</button>
        </div>

      </form>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection