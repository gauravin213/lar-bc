@extends('layouts.admin')

@section('content')
<div class="content-header"></div>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">

     @if ($message = Session::get('success'))
     <div class="alert alert-success">
      {{ $message }}
    </div>
    <script type="text/javascript">
      setTimeout(function(){
        jQuery('.alert-success').remove();
      }, 3000);
    </script>
    @endif
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
        <form id="csm_order_form" action="{{ route('orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <div class="card-body">

           <div class="form-group">
            <a class="btn btn-primary" href="{{ URL::previous() }}">Go Back</a>
           </div>
          
          <div class="form-group">
            <label for="exampleInputEmail1">Payment Status</label>
             <select name="payment_status" class="form-control" id="payment_status">
              <option value="">select</option>
              <option value="pending" {{$order->payment_status == 'pending'  ? 'selected' : ''}}>Pending</option>
               <option value="processing" {{$order->payment_status == 'processing'  ? 'selected' : ''}}>Processing</option>
              <option value="on-hold" {{$order->payment_status == 'on-hold'  ? 'selected' : ''}}>On Hold</option>
              <option value="completed" {{$order->payment_status == 'completed'  ? 'selected' : ''}}>Completed</option>
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
              <option value="{{$customer->id}}" {{$customer->id == $order->customer_id  ? 'selected' : ''}}>{{$customer->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">State</label>
            <select name="shipping_state" class="form-control" id="shipping_state">
              <option value="">select</option>
              <option value="1" {{$order->shipping_state == '1'  ? 'selected' : ''}}>UP/MP/Chhattisgarh</option>  
              <option value="2" {{$order->shipping_state == '2'  ? 'selected' : ''}}>Bihar/Jharkhand</option>        
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Shipping address</label>
            <textarea  name="shipping_address" class="form-control" id="shipping_address" placeholder="enter shipping address">{{$order->shipping_address}}</textarea>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Price Date</label>
            <input type="text" name="price_date" class="form-control" id="price_date" autocomplete="off" value="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remark</label>
            <textarea name="remark" class="form-control" id="remark" placeholder="enter shipping address">{{$order->remark}}</textarea>
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

                <tbody id="csm_items_body">
                  @foreach($order_items as $key => $order_item) 
                    <tr>
                        <td>
                          {{$order_item->name}} 
                          <input type="hidden" name="iten_data[{{$order_item->id}}][id]" value="{{$order_item->id}}">
                          <input type="hidden" name="iten_data[{{$order_item->id}}][product_id]" value="{{$order_item->product_id}}">
                        </td>

<td>
  @if($order_item->item_discount)
    <span style="text-decoration: line-through;">{{$order_item->price}}</span>  {{$order_item->item_discount_price}} 
  @else
    {{$order_item->price}} 
  @endif
  <input type="hidden" name="iten_data[{{$order_item->id}}][price]" value="{{$order_item->price}}">
</td>
<td>
  <input type="text" name="iten_data[{{$order_item->id}}][item_discount]" value="{{$order_item->item_discount}}" style="width:60px;">
  <input type="hidden" name="iten_data[{{$order_item->id}}][item_discount_price]" value="{{$order_item->item_discount_price}}" style="width:60px;">
</td>

                        <td><input type="number" class="itemqty" data-prodid="{{$order_item->id}}" name="iten_data[{{$order_item->id}}][qty]" value="{{$order_item->qty}}" style="width:60px;"></td>
                        <td>{{$order_item->line_subtotal}} <input type="hidden" name="iten_data[{{$order_item->id}}][line_subtotal]" value="{{$order_item->line_subtotal}}"></td>
                        <td><a href="#" class='csm_remove_item' data-product_id='{{$order_item->id}}'>X</a></td>
                    </tr>
                  @endforeach
                </tbody>

                <tbody id="csm_items_subtotal_body">
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <th>Subtotal</th>
                      <td> <span id="subtotal_label">{{$order->subtotal}}</span> <input type="hidden" name="subtotal" id="subtotal" value="{{$order->subtotal}}"></td>
                  </tr>
                </tbody>

              
                  @if ($order->discount !=0)
                   <tbody id="csm_item_discount_body">
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th>Discount <span id="discount_label">{{$order->discount}}</span>% <a href="#" id="remove_discount">Remove</a> <input type="hidden" name="discount" id="discount" value="{{$order->discount}}"></th>
                        <td>(-)<span id="discount_price_label">{{$order->discount_price}}</span> <input type="hidden" name="discount_price" id="discount_price" value="{{$order->discount_price}}"></td>
                      </tr>
                    </tbody>
                  @else
                  <tbody id="csm_item_discount_body" style="display: none;">
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th>Discount 0% <a href="#" id="remove_discount">Remove</a> <input type="hidden" name="discount" value="0"></th>
                        <td>(-)0 <input type="hidden" name="discount_price" value="0"></td>
                      </tr>
                      </tbody>
                  @endif

                  @if ($order->shipping !=0)
                   <tbody id="csm_item_shipping_body">
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th>Shipping <a href="#" id="remove_shipping">Remove</a></th>
                        <td><span id="shipping_label">{{$order->shipping}}</span> <input type="hidden" name="shipping" id="shipping" value="{{$order->shipping}}"></td>
                      </tr>
                    </tbody>
                  @else
                  <tbody id="csm_item_shipping_body" style="display: none;">
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <th>Shipping <a href="#" id="remove_shipping">Remove</a></th>
                      <td>0 <input type="hidden" name="shipping" value="0"></td>
                    </tr>
                  </tbody>
                  @endif

                <tbody id="csm_items_total_body">
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <th>Total</th>
                      <td><span id="total_label">{{$order->total}}</span> <input type="hidden" name="total" id="total" value="{{$order->total}}"></td>
                  </tr>
                </tbody>
            </table>
              </div>
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

           <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add-discount">
              Discount
            </button> -->

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