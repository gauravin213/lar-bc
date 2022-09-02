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
        <h3 class="card-title">Edit Plan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
         <form action="{{ route('member-bc-plans.update', $memberBcPlan->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>

         
         <div class="form-group">
            <label for="exampleInputEmail1">Group</label>
            <select name="group_id" class="form-control" id="group_id">
              <option>select</option>
              @foreach($groups as $group)
              <option value="{{$group->id}}" {{($group->id == $memberBcPlan->group_id ) ? 'selected' : ''}}>{{$group->title}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Member</label>
            <select name="member_id" class="form-control" id="member_id">
              <option>select</option>
              @foreach($members as $members)
              <option value="{{$members->id}}" {{($members->id == $memberBcPlan->member_id ) ? 'selected' : ''}} >{{$members->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Bc</label>
            <select name="bc_id" class="form-control" id="bc_id">
              <option>select</option>
              @foreach($bcs as $bc)
              <option value="{{$bc->id}}" {{($bc->id == $memberBcPlan->bc_id ) ? 'selected' : ''}} >{{$bc->title}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Emi Amount</label>
            <input type="text" name="emi_amount" class="form-control" id="emi_amount" placeholder="Enter emi_amount" value="{{$memberBcPlan->emi_amount}}">
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