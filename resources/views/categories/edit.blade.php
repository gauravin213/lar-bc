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
        <h3 class="card-title">Edit Product</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
         <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>

         
          <div class="form-group">
            <label for="exampleInputEmail1">Category Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{$category->name}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description" value="{{$category->description}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Parent</label>
            <input type="text" name="parent" class="form-control" id="parent" placeholder="Enter parent" value="{{$category->parent}}">
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