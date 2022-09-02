@extends('layouts.admin')

@section('content')

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

.row_width{
  width: 30%;
}
td.row_red {
  color: #ff3300;
}
td.row_green {
  color: #0cb50c;
}

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





<style>
  a.pre_item {
      float: right;
  }
  .customer_info_p{
    display: none;
  }
  .filter_form{
    margin-top: 5px;
  }

@media screen {
  
}
@media print {

  @page{ 
      size: auto; /* auto is the initial value */ 
      /* this affects the margin in the printer settings */ 
      margin: 15mm 20mm 15mm 20mm;  /*top left bottom right*/
  } 

  body{ 
      /* this affects the margin on the content before sending to printer */ 
      /*margin: 0px;  */
  }

  footer.main-footer {
      display: none;
  }
  .pre_itemx {
      display: none;
  }
  aside.main-sidebar.sidebar-dark-primary.elevation-4{
    display: none;
  }
  nav.main-header.navbar.navbar-expand.navbar-white.navbar-light{
    display: none;
  }
  a.btn.btn-primary.back-btn {
      display: none;
  }
  .card-header{
    display: none;
  }
  .customer_info_p{
    display: block;
  }

  .filter_form{
    display: none;
  }
  
}
</style>
<script type="text/javascript">
  function printDiv(divName) {
    window.print();
  }
</script>


<div class="content-header"></div>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Report</h3>
      </div>

    <form action="" method="GET" class="filter_form">
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
          <a href="{{ route('customer-transactions.show',$customer->id) }}" class="btn btn-danger">Clear</a>
         @endif
        </div>
      </div>
    </form>

      <!-- /.card-header -->
      <div class="card-body">

        <div class="card-body table-responsive p-0">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
          </div>

          <div class="form-group pre_itemx">
            <a class="pre_item" href="javascript://" onclick="printDiv('printableArea')">Print</a>
          </div>
          <div class="form-group">

            @if(is_object($customer))
            <div class="customer_info_p">
              <center ><h3>{{ $customer->name }}</h3></center>
            </div>
            @endif

             <table class="table table-hover text-nowrap border" style="margin-bottom: 32px;">
               <thead>
                <tr>
                  <th class="row_width">Total Debit</th>
                  <th class="row_width">Total Credit</th>
                  <th class="row_width">Net Balance</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="total_debit">
                      &#x20b9; {{$total_debit}}
                    </div>
                  </td>
                  <td>
                    <div class="total_credit">
                    &#x20b9; {{$total_credit}}
                  </div>
                  </td>
                  <td>
                    <div class="net_balance">
                    @if( $total_debit != $total_credit)
                       @if($total_debit > $total_credit)
                      <span class="net_balance_red">&#x20b9; {{$net_balance}} {{ucfirst($transaction_type)}} you will get</span>
                      @else
                       <span class="net_balance_green">&#x20b9; {{$net_balance}} {{ucfirst($transaction_type)}} you will give</span>
                      @endif
                    @else
                      <span class="net_balance_zero">&#x20b9; {{$net_balance}} {{ucfirst($transaction_type)}}</span>
                    @endif
                  </div>
                  </td>
                </tr>
              </tbody>
             </table>


            <table class="table table-hover text-nowrap border">
              <thead>
                <tr>
                  <th class="row_width">Entries</th>
                  <th class="row_width">Debit(Gave)</th>
                  <th class="row_width">Credit(Got)</th>
                  <th class="row_width">Balance</th>
                  <th>Status</th>
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
                            Balance: &#x20b9; {{ $customer_transaction->balance }}
                          </div>
                          <div>{{$customer_transaction->description}}</div>
                          @if($customer_transaction->created_at != $customer_transaction->updated_at)
                          <div>
                            Edited at: {{ date("d-m-Y h:i:sa", strtotime($customer_transaction->updated_at)) }}
                          </div>
                          @endif
                        </div>
                      </td>
                      <td class="row_red"> 
                        @if($customer_transaction->debit!=null)
                         &#x20b9; {{$customer_transaction->debit}}
                        @endif
                      </td>
                      <td class="row_green">
                        @if($customer_transaction->credit!=null)
                         &#x20b9; {{$customer_transaction->credit}}
                        @endif
                      </td>
                      <td> &#x20b9; {{$customer_transaction->balance}}
                         @if( $customer_transaction->balance !=0 )
                        <span class="transaction_type_{{$customer_transaction->transaction_type}}">{{ ucfirst($customer_transaction->transaction_type)}}</span>
                        @endif
                      </td>
                      <td> 
                         <span class="status_{{$customer_transaction->status }}">{{ ucfirst($customer_transaction->status) }}</span>
                      </td>
                    </tr>
                    @endforeach
                  
                </tbody>
              </table>
          </div>

        </div>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection