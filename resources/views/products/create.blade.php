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
        <h3 class="card-title">Add Product</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>
         
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
          </div>

         <!--  <div class="form-group">
            <label for="exampleInputEmail1">Slug</label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="Enter slug">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Sku</label>
            <input type="text" name="sku" class="form-control" id="sku" placeholder="Enter sku">
          </div> -->

          <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Price</label>
            <input type="text" name="price" class="form-control" id="price" placeholder="Enter price">
          </div>

          <!-- <div class="form-group">
            <label for="exampleInputEmail1">Sale Price</label>
            <input type="text" name="sale_price" class="form-control" id="sale_price" placeholder="Enter sale price">
          </div> -->

          <div class="form-group">
            <label for="exampleInputEmail1">Category</label>
             <select name="category_id" class="form-control" id="category_id">
              <option value="">select</option>
              @foreach($categories as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
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