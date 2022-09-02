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

    <div class="margin" style="margin-bottom: 5px;">
      <div class="btn-group">
        <a href="{{ url('admin/customers/create') }}" class="btn btn-primary">Add Customers</a>
      </div>
      <div class="btn-group">
        <button type="button" id="csm_export_btn" class="btn btn-success">Export</button>
      </div>
    </div>

    <!---->
    <form id="csm_export_form" action="{{url('/customers/exportcsv')}}" method="GET">
      <input type="hidden" name="s" id="search" class="form-control" placeholder="search" value="{{(isset($_GET['s'])) ? $_GET['s'] : ''}}">
    </form>
    <!---->

    <div>
      <div class="net_balance">
          <span class="net_balance_{{$balance_report['class']}}">Total balance &#x20b9; {{$balance_report['total_balance']}} {{$balance_report['label']}}</span>
      </div>
      <style type="text/css">
        .net_balance_red{
          color: #f22c2c;
          font-weight: bold;
        }
        .net_balance_green{
          color: #288328;
          font-weight: bold;
        }
      </style>
    </div>
    

    <form action="" method="GET">
      <!---->
      <div class="card">
        <div class="card-header">
         <h3 class="card-title">Search&nbsp; &nbsp; &nbsp;</h3>  
        </div>
        <div class="card-body">

          <div class="row" style="margin-top: 5px;">

            <div class="col-sm-6">

              <div class="row">

                <div class="col-sm-6">
                  <div class="filter_field">
                    <input type="text" name="s" id="search" class="form-control" placeholder="search" value="{{(isset($_GET['s'])) ? $_GET['s'] : ''}}">
                  </div>
                  <div class="filter_field">
                     <button class="btn btn-default">Search</button>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="filter_field">
                      <select name="sales_persone_id" class="form-control" id="sales_persone_id">
                          <option value="">Sales Persone</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}" {{(isset($_GET['sales_persone_id']) && $user->id==$_GET['sales_persone_id']) ? 'selected' : ''}}>{{$user->name}}</option>
                            @endforeach
                        </select>
                  </div>
                  <div class="filter_field">
                    <button class="btn btn-default">Filter</button>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-3">
                  <div class="filter_field">
                    @if(isset($_GET['s']) && $_GET['s'] !='' || isset($_GET['sales_persone_id']) && $_GET['sales_persone_id'] !='')
                      <a href="{{url('/admin/customers')}}" class="btn btn-danger">Remove Filter</a>
                    @endif
                  </div>
                </div>
              </div>
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
            <th>Name</th>
            <th>Company</th>
            <th>Mobile</th>
            <th>Wallet</th>
            <th>Sales Man</th>
            <th colspan="3">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($customers as $customer)
          <tr>
            <td>{{$customer->id}}</td>
            <td>{{$customer->name}}</td>
            <td>{{$customer->company_name}}</td>
            <td>
              @if($customer->mobile!='' && $customer->mobile_alternate!='')
              {{$customer->mobile}}, {{$customer->mobile_alternate}}
              @else
              {{$customer->mobile}}
              @endIf
            </td>
            <td>{{$customer->total_fund}}</td>
            <td>
              @if(is_object($customer->user))
              {{$customer->user->name}}
              @else
              N/A
              @endif
            </td>
            <td>
              @can('isAdministrator')
              <a class="btn btn-primary" href="{{ route('customers.edit',$customer->id) }}"><i class="fas fa-edit"></i></a> 
              @endcan

              @if($user_type!='sales_man')
                {!! Form::open(['class' => 'mydeleteform_'.$customer->id, 'method' => 'DELETE','route' => ['customers.destroy', $customer->id],'style'=>'display:inline']) !!}
                <!-- <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button> -->
                <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$customer->id}}"><i class="fas fa-trash-alt"></i></button>
                {{ Form::close() }}
              @endif

               <a class="btn btn-success" href="{{ route('customers.show',$customer->id) }}"><i class="fas fa-eye"></i></a>
               <?php
               $customer_id_url = 'admin/customer-transactions?customer_id='.$customer->id;
               ?>
               <a class="btn btn-success" href="{{ url($customer_id_url) }}">
               <i class="fa fa-credit-card" aria-hidden="true"></i>
              </a>
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
       {{ $customers->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection