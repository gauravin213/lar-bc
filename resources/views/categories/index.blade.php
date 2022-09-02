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
        <h1 class="m-0"><a href="{{ url('admin/categories/create') }}" class="btn btn-primary">Add category</a></h1>
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
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="filter_field">
                        @if(isset($_GET['s']) && $_GET['s'] !='')
                          <a href="{{url('/admin/categories')}}" class="btn btn-danger">Clear</a>
                        @endif
                      </div>
                    </div>
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


  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="card">
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
  <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach($categories as $category)
          <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>
              <a class="btn btn-primary" href="{{ route('categories.edit',$category->id) }}"><i class="fas fa-edit"></i></a>
              {!! Form::open(['class' => 'mydeleteform_'.$category->id,'method' => 'DELETE','route' => ['categories.destroy', $category->id],'style'=>'display:inline']) !!}
                <!-- <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button> -->
                <button class="btn btn-danger delete_ev" type="button" data-element_id="{{$category->id}}"><i class="fas fa-trash-alt"></i></button>
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
       {{ $categories->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection