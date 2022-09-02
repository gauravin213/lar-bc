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
        <h3 class="card-title">Edit Price</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
         <form action="{{ route('pricelists.update', $pricelist->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
         </div>

         
          <div class="form-group">
            <label for="exampleInputEmail1">Select Product</label>
            <div>
              <select name="product_id" class="form-control" id="product_id2">
              @foreach($products as $product)
                <option value="{{$product->id}}" {{$product->id == $pricelist->product_id  ? 'selected' : ''}}>{{$product->name}}</option>
              @endforeach
            </select>
            </div>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Date</label>
            <input type="text" name="price_date" class="form-control" id="price_date" placeholder="Enter price_date" value="{{$pricelist->price_date}}" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">State</label>
            <select name="state" class="form-control" id="state">
              <option value="" {{$pricelist->state == ''  ? 'selected' : ''}}>select</option>
              <option value="1" {{$pricelist->state == '1'  ? 'selected' : ''}}>UP/MP/Chhattisgarh</option>  
              <option value="2" {{$pricelist->state == '2'  ? 'selected' : ''}}>Bihar/Jharkhand</option>        
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Price</label>
            <input type="text" name="price" class="form-control" id="price" placeholder="Enter price" value="{{$pricelist->price}}">
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