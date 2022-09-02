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
        <h3 class="card-title">Add Bc</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form action="{{ route('bcs.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">gross_amount</label>
            <input type="text" name="gross_amount" class="form-control" id="gross_amount" placeholder="Enter gross_amount">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">loss_amount</label>
            <input type="text" name="loss_amount" class="form-control" id="loss_amount" placeholder="Enter loss_amount">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">commission_amount</label>
            <input type="text" name="commission_amount" class="form-control" id="commission_amount" placeholder="Enter commission_amount">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Total Bc Amount</label>
            <input type="text" name="total_bc_amount" class="form-control" id="total_bc_amount" placeholder="Enter total_bc_amount">
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