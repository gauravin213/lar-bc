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
        <h3 class="card-title">Add User</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="exampleInputEmail1">Password</label>
            <input type="text" name="password" class="form-control" id="password" placeholder="Enter password">
          </div>

          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Role</label>
            <select name="user_type" id="user_type" class="form-control" >
              <option value="">select</option>
              <option value="administrator">Administrator</option>
              <option value="sales_man">Sales Man</option>
            </select>
          </div> -->

          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Mobile No.</label>
            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter mobile No.">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Alternate Mobile No.</label>
            <input type="text" name="mobile_alternate" class="form-control" id="mobile_alternate" placeholder="Enter Alternate mobile No.">
          </div> -->

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