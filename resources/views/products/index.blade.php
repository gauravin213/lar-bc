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
        <h1 class="m-0"><a href="{{ url('admin/products/create') }}" class="btn btn-primary">Add Product</a></h1>
      </div><!-- /.col -->
    </div><!-- /.row -->

    <form action="" method="GET">
      <!---->
      <div class="card">
        <div class="card-header">
         <h3 class="card-title">Search&nbsp; &nbsp; &nbsp;</h3>  
        </div>
        <div class="card-body">
          <div class="row" style="margin-top: 5px;">

             <div class="col-sm-6">

              <div class="row">

                <div class="col-sm-6">
                  <div class="filter_field">
                    <input type="text" name="s" id="search" class="form-control" placeholder="search" value="{{(isset($_GET['s'])) ? $_GET['s'] : ''}}">
                  </div>
                  <div class="filter_field">
                     <button class="btn btn-default">Search</button>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="filter_field">
                    <select name="category_id" class="form-control" id="category_id">
                      <option value="">Category</option>
                      @foreach($categories as $category)
                      <option value="{{$category->id}}" {{(isset($_GET['category_id']) && $category->id==$_GET['category_id']) ? 'selected' : ''}}>{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="filter_field">
                    <button class="btn btn-default">Filter</button>
                  </div>
                  
                </div>

              </div>

             </div>

             <div class="col-sm-6">

              <div class="row">

                <div class="col-sm-3">
                  <div class="filter_field">
                    @if(isset($_GET['s']) && $_GET['s'] !='' || isset($_GET['category_id']) && $_GET['category_id'] !='')
                      <a href="{{url('/admin/products')}}" class="btn btn-danger">Remove Filter</a>
                    @endif
                  </div>
                </div>

               
              </div>
             </div>

          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!---->
    </form>

     <div class="row">
       <div class="col-sm-3">
       <form id="bulk_delete_action_form" action="{{url('users/destroy_bulk')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <button type="submit" id="bulk_delete_action_btn" class="btn btn-danger btn-sm" style="display: none;">Bulk delete</button>
        <input type="hidden" name="entity_ids" id="entity_ids">
      </form>
    </div>
    </div>


  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="card">
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">

     
      
          <table class="table table-hover text-nowrap" id="table_index">
          <thead>
            <tr>
              <th><input type="checkbox" id="selectAll" /></th>
              <th>ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Category</th>
              <th colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($products as $product)
            <tr>
              <td><input type="checkbox" class="selectAll" id="1" name="entity_id[]" value="{{$product->id}}" /></td>
              <td>{{$product->id}}</td>
              <td>{{$product->name}}</td>
              <td>{{$product->price}}</td>
              <td>
                @if(is_object($product->category))
                {{$product->category->name}}
                @else
                N/A
                @endif
              </td>
              <td>
                <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}"><i class="fas fa-edit"></i></a> 
                {!! Form::open(['class' => 'mydeleteform_'.$product->id, 'method' => 'DELETE','route' => ['products.destroy', $product->id],'style'=>'display:inline']) !!} 
                 <!-- {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!} -->
                <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$product->id}}"><i class="fas fa-trash-alt"></i></button>
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
       {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection