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
        <h1 class="m-0"><a href="{{ url('admin/member-bc-plans/create') }}" class="btn btn-primary">Add Plan</a></h1>
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
            <th>Member</th>
            <th>Bc Plan</th>
            <th>Emi Amount</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($memberBcPlans as $memberBcPlan)
          <tr>
            <td>{{$memberBcPlan->id}}</td>
            <td>
              @if(is_object($memberBcPlan->group))
              {{$memberBcPlan->group->title}}
              @else
              N/A
              @endif
            </td>
            <td>
              @if(is_object($memberBcPlan->member))
              {{$memberBcPlan->member->name}}
              @else
              N/A
              @endif
            </td>
            <td>
              @if(is_object($memberBcPlan->bc))
              {{$memberBcPlan->bc->title}}
              @else
              N/A
              @endif
            </td>
            <td>{{$memberBcPlan->emi_amount}}</td>
            <td>
              <a class="btn btn-primary" href="{{ route('member-bc-plans.edit',$memberBcPlan->id) }}"><i class="fas fa-edit"></i></a>
              {!! Form::open(['class' => 'mydeleteform_'.$memberBcPlan->id,'method' => 'DELETE','route' => ['member-bc-plans.destroy', $memberBcPlan->id],'style'=>'display:inline']) !!}
                <!-- <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button> -->
                <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$memberBcPlan->id}}"><i class="fas fa-trash-alt"></i></button>
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
       {{ $memberBcPlans->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection