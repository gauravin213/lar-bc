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
        <h3 class="card-title">Add Group</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Enter email">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Mobile</label>
            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter mobile">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">address</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="Enter address">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Group</label>
            <select name="group_id" class="form-control" id="group_id">
              <option>select</option>
              @foreach($groups as $group)
              <option value="{{$group->id}}">{{$group->title}}</option>
              @endforeach
            </select>
          </div>

        
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection