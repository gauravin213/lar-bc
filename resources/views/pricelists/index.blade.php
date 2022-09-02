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

     <!---->
    <form id="csm_export_form" action="{{url('/pricelists/exportcsv')}}" method="GET">
      <input type="hidden" name="from_date" class="form-control" autocomplete="off" value="{{(isset($_GET['from_date'])) ? $_GET['from_date'] : ''}}">
      <!-- <input type="hidden" name="to_date" class="form-control" autocomplete="off" value="{{(isset($_GET['to_date'])) ? $_GET['to_date'] : ''}}"> -->
      <input type="hidden" name="state" class="form-control" autocomplete="off" value="{{(isset($_GET['state'])) ? $_GET['state'] : ''}}">
    </form>
    <!---->
    <form action="" method="GET">
      <!---->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Filter &nbsp; &nbsp; &nbsp;</h3> 
           <div>
            <button type="button" id="csm_export_btn" class="btn btn-success btn-sm">Export</button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <input type="text" name="from_date" id="from_date" class="form-control" autocomplete="off" value="{{(isset($_GET['from_date'])) ? $_GET['from_date'] : ''}}" placeholder="date">
            </div>
            <div class="col-3">
             <select name="state" class="form-control" id="state">
              <option value="">Select state</option>
              <option value="1" {{(isset($_GET['state']) && $_GET['state'] =='1') ? 'selected' : ''}} >UP/MP/Chhattisgarh</option>  
              <option value="2" {{(isset($_GET['state']) && $_GET['state'] =='2') ? 'selected' : ''}}>Bihar/Jharkhand</option>        
            </select>
            </div>
            <!-- <div class="col-3">
               <input type="text" name="to_date" id="to_date" class="form-control" autocomplete="off" value="{{(isset($_GET['to_date'])) ? $_GET['to_date'] : ''}}">
            </div> -->
            <div class="col-3">
             <button class="btn btn-default">Filter</button>
              @if(isset($_GET['from_date']))
              <a href="{{url('/admin/pricelists')}}" class="btn btn-danger">Remove Filter</a>
             @endif
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!---->
    </form>


    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><a href="{{ url('admin/pricelists/create') }}" class="btn btn-primary">Add Price</a></h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
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
            <th>Product Name</th>
            <th>Price Date</th>
            <th>State</th>
            <th>Price</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($pricelists as $pricelist)
          <tr>
            <td>
            	@if(is_object($pricelist->product))
            	{{$pricelist->product->name}}
            	@endif
            </td>
            <td>{{$pricelist->price_date}}</td>
             <td>
                @if($pricelist->state == 1)
                <span>UP/MP/Chhattisgarh</span>
                @elseif($pricelist->state == 2)
                <span>Bihar/Jharkhand</span>
                @else
                <span>N/A</span>
                @endif
             </td>
            <td>{{$pricelist->price}}</td>
            <td>
              <a class="btn btn-primary" href="{{ route('pricelists.edit',$pricelist->id) }}"><i class="fas fa-edit"></i></a>
              {!! Form::open(['class' => 'mydeleteform_'.$pricelist->id, 'method' => 'DELETE','route' => ['pricelists.destroy', $pricelist->id],'style'=>'display:inline']) !!}  
              <!-- {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} -->
              <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$pricelist->id}}"><i class="fas fa-trash-alt"></i></button>
               {{ Form::close() }}
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
       {{ $pricelists->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection