@extends('layouts.admin')

@section('content')
<!-- <script>
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script> -->
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    @if ($message = Session::get('success'))
     <div class="alert alert-success">
      {{ $message }}
    </div>
    @endif


    <div class="margin" style="margin-bottom: 5px;">
      <div class="btn-group">
        <h1 class="m-0"><a href="{{ url('admin/orders/create') }}" class="btn btn-primary">Add Order</a></h1>
      </div>
      <div class="btn-group">
        <button type="button" id="csm_export_btn" class="btn btn-success btn">Export</button>
      </div>
    </div>


    <!---->
    <form id="csm_export_form" action="{{url('/orders/exportcsv')}}" method="GET">
      <input type="hidden" name="payment_status" value="{{(isset($_GET['payment_status'])) ? $_GET['payment_status'] : ''}}"> 
      <input type="hidden" name="customer_id" value="{{(isset($_GET['customer_id'])) ? $_GET['customer_id'] : ''}}"> 
      <input type="hidden" name="placed_by" value="{{(isset($_GET['placed_by'])) ? $_GET['placed_by'] : ''}}"> 
      <input type="hidden" name="from_date" class="form-control" autocomplete="off" value="{{(isset($_GET['from_date'])) ? $_GET['from_date'] : ''}}">
      <input type="hidden" name="to_date" class="form-control" autocomplete="off" value="{{(isset($_GET['to_date'])) ? $_GET['to_date'] : ''}}">
    </form>
    <!---->

    <form action="" method="GET">
      <!---->
      <div class="card">

        <div class="card-header">
           <h3 class="card-title">Filter &nbsp; &nbsp; &nbsp;</h3> 
        </div>

        <div class="card-body">

          <div class="row">
            <div class="col-sm-4">
              <select name="payment_status" class="form-control" id="payment_status">
                <option value="">Payment status</option>
                <option value="pending"  {{(isset($_GET['payment_status']) && $_GET['payment_status'] =='pending') ? 'selected' : ''}}>Pending</option>
                <option value="processing"  {{(isset($_GET['payment_status']) && $_GET['payment_status'] =='processing') ? 'selected' : ''}}>Processing</option>
                <option value="on-hold" {{(isset($_GET['payment_status']) && $_GET['payment_status'] =='on-hold') ? 'selected' : ''}}>On Hold</option>
                <option value="completed" {{(isset($_GET['payment_status']) && $_GET['payment_status'] =='completed') ? 'selected' : ''}}>Completed</option>
              </select>
            </div>
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
          </div>

          <div class="row">
            <div class="col-sm-4">
              <input type="text" name="from_date" id="from_date" class="form-control" autocomplete="off" value="{{(isset($_GET['from_date'])) ? $_GET['from_date'] : ''}}" placeholder="from">
            </div>
            <div class="col-sm-4">
               <input type="text" name="to_date" id="to_date" class="form-control" autocomplete="off" value="{{(isset($_GET['to_date'])) ? $_GET['to_date'] : ''}}" placeholder="to">
            </div>
            <div class="col-sm-4">
             <button class="btn btn-default">Filter</button>
             @if(count($args_filter)!=0)
              <a href="{{url('/admin/orders')}}" class="btn btn-danger">Remove Filter</a>
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
            <th>Payment Status</th>
            <th>Placed By</th>
            <th>Customer</th>
            <th>Wallet</th>
            <th>Total</th>
            <th>Balance</th>
            <th>Date</th>
            <th colspan="4">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($orders as $order)
          <tr>
            <td>{{$order->id}}</td>
            <td>
              @if($order->payment_status =='pending')
                <span style="background-color:#588ca3;color: #ffff; padding: 3px; border-radius: 2px;">Pending</span>
                 @elseif($order->payment_status =='processing')
                <span style="background-color:#63a363;color: #ffff; padding: 3px; border-radius: 2px;">Processing</span>
              @elseif($order->payment_status =='on-hold')
                <span style="background-color:orange;color: #ffff; padding: 3px; border-radius: 2px;">On Hold</span>
              @elseif($order->payment_status =='completed')
                <span style="background-color:#63a363;color: #ffff; padding: 3px; border-radius: 2px;">Completed</span>
              @endif
            </td>
          
            <td>
              @if(is_object($order->user))
                {{$order->user->name}}
              @endif
            </td> 

            <td>
              @if(is_object($order->customer))
              <span>{{$order->customer->name}}</span><br>
                @if(!empty($order->customer->company_name))
                <span style="color:green;">({{$order->customer->company_name}})</span>
                @endif
              @endif
            </td> 

            <td>
              @if(is_object($order->customer))
                {{$order->customer->total_fund}}
              @endif
            </td> 


            <td>{{$order->total}}</td>
            <td>{{$order->balance_amount}}</td>
            <td>{{$order->created_at}}</td>
            <td>

              @can('isAdministrator')
              <a class="btn btn-primary" href="{{ route('orders.edit',$order->id) }}"><i class="fas fa-edit"></i></a> 
              @endcan

              @can('isSalesMane')
                @if($order->payment_status !='completed')
                <a class="btn btn-primary" href="{{ route('orders.edit',$order->id) }}"><i class="fas fa-edit"></i></a> 
                @endif
              @endcan


              @if($user_type!='sales_man')
              {!! Form::open(['class' => 'mydeleteform_'.$order->id, 'method' => 'DELETE','route' => ['orders.destroy', $order->id],'style'=>'display:inline']) !!}
              <!-- {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} -->
              <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$order->id}}"><i class="fas fa-trash-alt"></i></button>
               {{ Form::close() }}
              @endif
               

              

              <a class="btn btn-success" href="{{ route('orders.show',$order->id) }}"><i class="fas fa-eye"></i></a>

              @if($order->payment_status !='processing')
               <a class="btn btn-info" href="{{ url('admin/transactions/create?order_id='.$order->id.'&customer_id='.$order->customer_id.'&placed_by='.$order->placed_by)}}">Pay <i class="fas fa-rupee-sign"></i></a>
              @endif
                
              {!! Form::close() !!}
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
       {{ $orders->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection