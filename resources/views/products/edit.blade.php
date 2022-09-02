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
         <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>

         
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="{{$product->name}}">
          </div>

         <!--  <div class="form-group">
            <label for="exampleInputEmail1">Slug</label>
            <input type="text" name="slug" class="form-control" id="slug" placeholder="Enter slug" value="{{$product->slug}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Sku</label>
            <input type="text" name="sku" class="form-control" id="sku" placeholder="Enter sku" value="{{$product->sku}}">
          </div> -->

          <div class="form-group">
            <label for="exampleInputEmail1">Description</label>
            <input type="text" name="description" class="form-control" id="description" placeholder="Enter description" value="{{$product->description}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Price</label>
            <input type="text" name="price" class="form-control" id="price" placeholder="Enter price" value="{{$product->price}}">
          </div>

         <!--  <div class="form-group">
            <label for="exampleInputEmail1">Sale Price</label>
            <input type="text" name="sale_price" class="form-control" id="sale_price" placeholder="Enter sale price" value="{{$product->sale_price}}">
          </div> -->

          <div class="form-group">
            <label for="exampleInputEmail1">Category</label>
             <select name="category_id" class="form-control" id="category_id">
              <option value="">select</option>
              @foreach($categories as $category)
              <option value="{{$category->id}}" {{$category->id == $product->category_id  ? 'selected' : ''}}>{{$category->name}}</option>
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