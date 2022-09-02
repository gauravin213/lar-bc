@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    @if ($message = Session::get('success'))
     <div class="alert alert-success">
      {{ $message }}
    </div>
    @endif
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><a href="{{ url('admin/advance-payments/create') }}" class="btn btn-primary">Add Payment</a></h1>
      </div><!-- /.col -->
    </div><!-- /.row -->


    <form action="" method="GET">
      <!---->
      <div class="card">

        <div class="card-header">
           <h3 class="card-title">Filter &nbsp; &nbsp; &nbsp;</h3> 
        </div>

        <div class="card-body">

          <div class="row">
            
            <div class="col-sm-4">
             <select name="customer_id" class="form-control" id="customer_id">
                <option value="">Customer</option>
                @foreach($customers as $customer)
                <option value="{{$customer->id}}" {{(isset($_GET['customer_id']) && $customer->id==$_GET['customer_id']) ? 'selected' : ''}}>{{$customer->name}}({{$customer->company_name}})</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-4">
              <select name="placed_by" class="form-control" id="placed_by">
                <option value="">User</option>
                @foreach($users as $user)
                <option value="{{$user->id}}" {{(isset($_GET['placed_by']) && $user->id==$_GET['placed_by']) ? 'selected' : ''}}>{{$user->name}}</option>
                @endforeach
              </select>
            </div>

             <div class="col-sm-4">
              <input type="text" name="payment_date" id="payment_date" class="form-control" autocomplete="off" value="{{(isset($_GET['payment_date'])) ? $_GET['payment_date'] : ''}}" placeholder="Payment date">
            </div>

          </div>

          <div class="row">
           
            <div class="col-sm-4">
             <button class="btn btn-default">Filter</button>
             @if(count($args_filter)!=0)
              <a href="{{url('/admin/advance-payments')}}" class="btn btn-danger">Remove Filter</a>
             @endif
            </div>
          </div>

        </div>
        <!-- /.card-body -->
      </div>
      <!---->
    </form>


  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="card">
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
  <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>#</th>
            <th>Customer Name</th>
            <th>Amount</th>
            <th>Payment Date</th>
            <th>Created At</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($advance_payments as $advance_payment)
          <tr>
            <td>{{$advance_payment->id}}</td>
            <td>
              @if(is_object($advance_payment->customer))
                {{$advance_payment->customer->name}}
              @endif
            </td>
            <td>{{$advance_payment->amount}}</td>
            <td>
              @if($advance_payment->payment_date!='')
                {{date("d-m-Y", strtotime($advance_payment->payment_date))}}
              @endif
            </td>
            <td>{{$advance_payment->created_at}}</td>
            <td>
              <a class="btn btn-primary" href="{{ route('advance-payments.edit',$advance_payment->id) }}"><i class="fas fa-edit"></i></a>

              @if($user_type!='sales_man')
                {!! Form::open(['class' => 'mydeleteform_'.$advance_payment->id,'method' => 'DELETE','route' => ['advance-payments.destroy', $advance_payment->id],'style'=>'display:inline']) !!}
                  <!-- <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button> -->
                  <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$advance_payment->id}}"><i class="fas fa-trash-alt"></i></button>
                {{ Form::close() }}
              @endif
 
            </td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </div>


    <!-- /.card-body -->
    <div class="card-header">
      <div class="card-tools">
        <!--pagination-->
       {{ $advance_payments->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection