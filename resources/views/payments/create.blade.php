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
        <h3 class="card-title">Add Payment</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>

          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Member</label>
            <input type="text" name="member_id" class="form-control" id="member_id" placeholder="Enter member_id">
          </div> -->

          <div class="form-group">
            <label for="exampleInputEmail1">Member</label>
            <select name="member_id" class="form-control" id="member_id">
              <option>select</option>
              @foreach($members as $members)
              <option value="{{$members->id}}">{{$members->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Bc Plan</label>
            <input type="text" name="member_bc_plan_id" class="form-control" id="member_bc_plan_id" placeholder="Enter member_bc_plan_id">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Emi Amount</label>
            <input type="text" name="paid_emi_amount" class="form-control" id="paid_emi_amount" placeholder="Enter paid_emi_amount">
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