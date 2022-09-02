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
        <h1 class="m-0"><a href="{{ url('admin/bcs/create') }}" class="btn btn-primary">Add Bc</a></h1>
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
            <th>#</th>
            <th>Group</th>
            <th>Title</th>
            <th>Gross Amount</th>
            <th>Loss Amount</th>
            <th>Commission Amount</th>
            <th>Total Bc Amount</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($bcs as $bc)
          <tr>
            <td>{{$bc->id}}</td>
            <td>
              @if(is_object($bc->group))
              {{$bc->group->title}}
              @else
              N/A
              @endif
            </td>
            <td>{{$bc->title}}</td>
            <td>{{$bc->gross_amount}}</td>
            <td>{{$bc->loss_amount}}</td>
            <td>{{$bc->commission_amount}}</td>
            <td>{{$bc->total_bc_amount}}</td>
            <td>
              <a class="btn btn-primary" href="{{ route('bcs.edit',$bc->id) }}"><i class="fas fa-edit"></i></a>
              {!! Form::open(['class' => 'mydeleteform_'.$bc->id,'method' => 'DELETE','route' => ['bcs.destroy', $bc->id],'style'=>'display:inline']) !!}
                <!-- <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button> -->
                <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$bc->id}}"><i class="fas fa-trash-alt"></i></button>
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
       {{ $bcs->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection