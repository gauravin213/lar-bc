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
        <h3 class="card-title">Add Transaction</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form action="{{ route('customer-transactions.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
          </div>

          <!--hidden-->
           <input type="hidden" name="customer_id" id="customer_id" value="{{(isset($_GET['customer_id'])) ? $_GET['customer_id'] : ''}}">
          <!--hidden-->
         
          <div class="form-group">
            <label for="exampleInputEmail1">Amount</label>
            <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter amount">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Attachment</label>
            <input type="file" name="attachment" class="form-control preview_img" id="attachment" accept="image/*">
           <img src="" id="pan_no_img" style="width: 20%;" />
          </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-danger" name="transaction_type" value="debit">Debit</button>
          <button type="submit" class="btn btn-success" name="transaction_type" value="credit">Credit</button>
        </div>
      </form>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection