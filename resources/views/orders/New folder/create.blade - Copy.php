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
        <h3 class="card-title">Add Order</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
        <form id="csm_order_form" action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card-body">

          <div class="form-group">
            <a class="btn btn-primary" href="{{ URL::previous() }}">Go Back</a>
           </div>
           
          <div class="form-group">
            <label for="exampleInputEmail1">Payment Status</label>
            <select name="payment_status" class="form-control" id="payment_status">
              <option value="">select</option>
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="on-hold">On Hold</option>
              <option value="completed">Completed</option>
            </select>
          </div>

          <div class="form-group" style="display: none;">
            <label for="exampleInputEmail1">Placed By</label>
            <input type="hidden" name="placed_by" class="form-control" id="placed_by" placeholder="Enter placed_by" value="{{$user_id}}">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Customer Name</label>
            <select name="customer_id" class="form-control" id="customer_id">
              <option value="">select</option>
              @foreach($customers as $customer)
              <option value="{{$customer->id}}">{{$customer->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">State</label>
            <select name="shipping_state" class="form-control" id="shipping_state">
              <option value="">select</option>
              <option value="1">UP/MP/Chhattisgarh</option>  
              <option value="2">Bihar/Jharkhand</option>        
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Shipping address</label>
            <textarea  name="shipping_address" class="form-control" id="shipping_address" placeholder="enter shipping address"></textarea>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Price Date</label>
            <input type="text" name="price_date" class="form-control" id="price_date" autocomplete="off" value="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remark</label>
            <textarea name="remark" class="form-control" id="remark" placeholder="enter shipping address"></textarea>
          </div>
          
          <div class="form-group">
            <div class="card-body">
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Item Discount</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="csm_items_body"></tbody>

                <tbody id="csm_items_subtotal_body">
                  <tr>
                      <td></td>
                      <td></td>
                      <th>Subtotal</th>
                      <td><span id="subtotal_label">0</span> <input type="hidden" name="subtotal" id="subtotal" value="0"></td>
                  </tr>
                </tbody>

                <tbody id="csm_item_discount_body" style="display: none;">
                  <tr>
                    <td></td>
                    <td></td>
                    <th>Discount 0% <a href="#" id="remove_discount">Remove</a> <input type="hidden" name="discount" value="0"></th>
                    <td>(-)0 <input type="hidden" name="discount_price" value="0"></td>
                  </tr>
                </tbody>

                <tbody id="csm_item_shipping_body" style="display: none;">
                  <tr>
                    <td></td>
                    <td></td>
                    <th>Shipping <a href="#" id="remove_shipping">Remove</a></th>
                    <td>0 <input type="hidden" name="shipping" value="0"></td>
                  </tr>
                </tbody>

                <tbody id="csm_items_total_body">
                  <tr>
                      <td></td>
                      <td></td>
                      <th>Total</th>
                      <td><span id="total_label">0</span> <input type="hidden" name="total" id="total" value="0"></td>
                  </tr>
                </tbody>
              </div>
            </table>
            </div>
          </div>


           <!--category discount-->
           <div class="form-group" id="category_discount_div">
            <label>Category Discount: </label>
            <table class="table">
              <tbody id="category_discount_append">
              </tbody>
            </table>
          </div>
          <!--category discount-->
          

          <div class="form-group">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add-item">
              Add Items
            </button>

             <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#add-discount">
              Discount
            </button>-->

             <button type="button" class="btn btn-default" id="cat_discount_btn">
              Discount
            </button>

            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add-shipping">
              Shipping
            </button>

            <button type="button" class="btn btn-default" id="calculate_cart_btn">
              Calculate
            </button>
            
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