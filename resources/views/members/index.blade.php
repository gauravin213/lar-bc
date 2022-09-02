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
        <h1 class="m-0"><a href="{{ url('admin/members/create') }}" class="btn btn-primary">Add Member</a></h1>
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
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Group</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($members as $member)
          <tr>
            <td>{{$member->id}}</td>
            <td>{{$member->name}}</td>
            <td>{{$member->email}}</td>
            <td>{{$member->mobile}}</td>
             <td>
              @if(is_object($member->group))
              {{$member->group->title}}
              @else
              N/A
              @endif
            </td>
            <td>
              <a class="btn btn-primary" href="{{ route('members.edit',$member->id) }}"><i class="fas fa-edit"></i></a>
              {!! Form::open(['class' => 'mydeleteform_'.$member->id,'method' => 'DELETE','route' => ['members.destroy', $member->id],'style'=>'display:inline']) !!}
                <!-- <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button> -->
                <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$member->id}}"><i class="fas fa-trash-alt"></i></button>
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
       {{ $members->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection