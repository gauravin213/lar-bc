@extends('layouts.admin')

@section('content')

<style type="text/css">
  /*
  Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
  */
  @media
    only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {

    /* Force table to not be like tables anymore */
    .table_m_r, .table_m_r thead, .table_m_r tbody, .table_m_r th, .table_m_r td, .table_m_r tr {
      display: block;
    }

    /* Hide table headers (but not display: none;, for accessibility) */
    .table_m_r thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }

      .table_m_r tr {
        margin: 0 0 1rem 0;
      }
        
      .table_m_r tr:nth-child(odd) {
        background: #ccc;
      }
    
    .table_m_r td {
      /* Behave  like a "row" */
      border: none;
      border-bottom: 1px solid #eee;
      position: relative;
      padding-left: 50%;
    }

    .table_m_r td:before {
      /* Now like a table header */
      position: absolute;
      /* Top/left values mimic padding */
      top: 0;
      left: 6px;
      width: 45%;
      padding-right: 10px;
      white-space: nowrap;
    }

    /*
    Label the data
      You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
    */
    .table_m_r td:nth-of-type(1):before { content: "Name"; }
    .table_m_r td:nth-of-type(2):before { content: "Price"; }
    .table_m_r td:nth-of-type(3):before { content: "Qty"; }
    .table_m_r td:nth-of-type(4):before { content: "Subtotal"; }
    .table_m_r td:nth-of-type(5):before { content: "Item Discount"; }
    .table_m_r td:nth-of-type(6):before { content: "Action"; }


    /*
    * Custom
    */

  }
  /*
  * Custom
  */
  .table_m_r th {
      width: 24.75rem;
      border: 1px solid;
      padding: 4px;
  }

  .table_m_r td {
    border: 1px solid;
  }

  </style>

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
            <label for="exampleInputEmail1">Party Name</label>
            <select name="customer_id" class="form-control" id="customer_id">
              <option value="">select</option>
              @foreach($customers as $customer)
              <option value="{{$customer->id}}">{{$customer->name}}({{$customer->company_name}})</option>
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
            <label for="exampleInputEmail1">Price Date</label>
            <input type="text" name="price_date" class="form-control" id="price_date" autocomplete="off" value="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Shipping address</label>
            <textarea  name="shipping_address" class="form-control" id="shipping_address" placeholder="Enter Shipping Address"></textarea>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Remark</label>
            <textarea name="remark" class="form-control" id="remark" placeholder="Enter Remark"></textarea>
          </div>
          
          <div class="form-group">
            <div class="card-body">
              <div class="card-body= table-responsive p-0">
                <table class="table= table-hover= text-nowrap= table_m_r">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Item Discount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="csm_items_body"></tbody>
              </div>
            </table>
            </div>
          </div>

          <div class="form-group">
            <div class="card-body">
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
        
                <tbody id="csm_items_subtotal_body">
                  <tr>
                      <th>Subtotal</th>
                      <td><span id="subtotal_label">0</span> <input type="hidden" name="subtotal" id="subtotal" value="0"></td>
                  </tr>
                </tbody>

                <tbody id="csm_item_discount_body" style="display: none;">
                  <tr>
                    <th>Discount 0% <a href="#" id="remove_discount">Remove</a> <input type="hidden" name="discount" value="0"></th>
                    <td>(-)0 <input type="hidden" name="discount_price" value="0"></td>
                  </tr>
                </tbody>

                <tbody id="csm_item_shipping_body" style="display: none;">
                  <tr>
                    <th>Shipping <a href="#" id="remove_shipping">Remove</a></th>
                    <td>0 <input type="hidden" name="shipping" value="0"></td>
                  </tr>
                </tbody>

                <tbody id="csm_items_total_body">
                  <tr>
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