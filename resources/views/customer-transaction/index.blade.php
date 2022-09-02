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
      @if($customer_id = $_GET['customer_id'])
      <?php
      $customer_transactions_create_url = 'admin/customer-transactions/create?customer_id='.$customer_id;
      ?>
      <div class="btn-group">
        <a href="{{ url($customer_transactions_create_url) }}" class="btn btn-primary">Create New Transaction</a>
      </div>
      @endif

       <a class="btn btn-success" href="{{ route('customer-transactions.show',$customer_id) }}">Report</a>
    </div>

    <div>
     <!--  <div class="total_debit">
        Total debit {{$total_debit}}
      </div>
      <div class="total_credit">
        Total credit {{$total_credit}}
      </div> -->
      <div class="net_balance">
        @if( $total_debit != $total_credit)
           @if($total_debit > $total_credit)
          <span class="net_balance_red">Net balance &#x20b9; {{$net_balance}} you will get</span>
          @else
           <span class="net_balance_green">Net balance &#x20b9; {{$net_balance}} you will give</span>
          @endif
        @else
          <span class="net_balance_zero">Net balance {{$net_balance}}</span>
        @endif
      </div>
    </div>
    <style type="text/css">
      .total_debit {
        color: #f22c2c;
      }
      .total_credit {
          color: #288328;
      }
      .net_balance_red{
        color: #f22c2c;
        font-weight: bold;
      }
      .net_balance_green{
        color: #288328;
        font-weight: bold;
      }
      /*.net_balance_zero{
        font-weight: bold;
      }*/
      .transaction_type_dr{
        color: #f22c2c;
      }
      .transaction_type_cr{
        color: #288328;
      }

      .status_successful{
        color: green;
      }
      .status_pending{
        color: orange
      }
      .status_failed{
        color: red;
      }
    </style>

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
            <th>Entries</th>
            <th>Debit(Gave)</th>
            <th>Credit(Got)</th>
            <th>Balance</th>
            <th>Status</th>
            @can('isAdministrator')
               <th>Action</th>
            @endcan
          </tr>
        </thead>
        <tbody>
          @foreach($customer_transactions as $customer_transaction)
          <tr>
            <td>
              <div>
                <div>
                  {{ date('d M y h:i A', strtotime($customer_transaction->created_at)) }}
                </div>
                <div>
                  @if(is_object($customer_transaction->user))
                    Sales man: {{ $customer_transaction->user->name }}
                  @endif
                </div>
                <div>
                  @if(is_object($customer_transaction->customer))
                    Customer: {{ $customer_transaction->customer->name }}
                  @endif
                </div>
                <div>
                  Balance: &#x20b9; {{ $customer_transaction->balance }}
                </div>
                <div>{{$customer_transaction->description}}</div>
                <div>
                  @if($customer_transaction->attachment!='')
                  <a href="{{url($customer_transaction->attachment)}}" data-toggle="lightbox" data-title="Profile Image" data-gallery="gallery">
                    <img src="{{url($customer_transaction->attachment)}}" id="pan_no_img" style="width: 50px;" /> 
                  </a>
                  @endif
                </div>

                @if($customer_transaction->created_at != $customer_transaction->updated_at)
                <div>
                  Edited at: {{ date("d-m-Y h:i:sa", strtotime($customer_transaction->updated_at)) }}
                </div>
                @endif

              </div>
            </td>
            <td> 
              @if($customer_transaction->debit!=null)
               &#x20b9; {{$customer_transaction->debit}}
              @endif
            </td>
            <td>
              @if($customer_transaction->credit!=null)
               &#x20b9; {{$customer_transaction->credit}}
              @endif
            </td>
            <td> 
              &#x20b9; {{$customer_transaction->balance}} 
              @if( $customer_transaction->balance !=0 )
              <span class="transaction_type_{{$customer_transaction->transaction_type}}">{{ ucfirst($customer_transaction->transaction_type)}}</span>
              @endif
            </td>
            <td> 
               <span class="status_{{$customer_transaction->status }}">{{ ucfirst($customer_transaction->status) }}</span>
            </td>

            <td>
              @can('isAdministrator')
              <a class="btn btn-primary" href="{{ route('customer-transactions.edit',$customer_transaction->id) }}"><i class="fas fa-edit"></i></a> 

               {!! Form::open(['class' => 'mydeleteform_'.$customer_transaction->id, 'method' => 'DELETE','route' => ['customer-transactions.destroy', $customer_transaction->id],'style'=>'display:inline']) !!}
                <!-- <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button> -->
                <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$customer_transaction->id}}"><i class="fas fa-trash-alt"></i></button>
              {{ Form::close() }}

              @endcan

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
       {{ $customer_transactions->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection