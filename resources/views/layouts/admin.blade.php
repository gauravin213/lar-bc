<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admin-lte-3.1.0-rc/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin-lte-3.1.0-rc/dist/css/adminlte.min.css') }}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('admin-lte-3.1.0-rc/plugins/select2/css/select2.min.css') }}">

  <!--jquery-ui-->
  <link rel="stylesheet" href="{{ asset('admin-lte-3.1.0-rc/plugins/jquery-ui/jquery-ui.min.css') }}">

  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{ asset('admin-lte-3.1.0-rc/plugins/ekko-lightbox/ekko-lightbox.css') }}">


<style type="text/css">
.content-wrapper {
  min-height: 1200px !important;
}
.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}
.modal-content {
    margin-top: 150px;
}

.filter_field {
    display: inline-flex;
}
</style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">


    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      @guest
        @if (Route::has('login'))
            <li class="nav-item d-none d-sm-inline-block">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
        @endif
        
        @else
            <li class="nav-item d-none d-sm-inline-block">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>

    <!-- SEARCH FORM -->
   <!--  <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto" style="display: none;">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('admin-lte-3.1.0-rc/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('admin-lte-3.1.0-rc/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('admin-lte-3.1.0-rc/dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('admin-lte-3.1.0-rc/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CSM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('admin-lte-3.1.0-rc/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Hi {{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="{{ url('admin') }}" class="nav-link {{ (request()->segment(2) == '') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('admin/groups') }}" class="nav-link {{ (request()->segment(2) == 'groups') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Groups
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/members') }}" class="nav-link {{ (request()->segment(2) == 'members') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Members
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/bcs') }}" class="nav-link {{ (request()->segment(2) == 'bcs') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Bc
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/member-bc-plans') }}" class="nav-link {{ (request()->segment(2) == 'member-bc-plans') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Member Bc Plans
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/payments') }}" class="nav-link {{ (request()->segment(2) == 'payments') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Payments
              </p>
            </a>
          </li>



          <!-- <li class="nav-item">
            <a href="{{ url('admin/group-bc-relations') }}" class="nav-link {{ (request()->segment(2) == 'group-bc-relations') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Group Bc Relations
              </p>
            </a>
          </li> -->


          @can('isAdministrator')
          <!-- <li class="nav-item">
            <a href="{{ url('admin/products') }}" class="nav-link {{ (request()->segment(2) == 'products') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Products  {{ (request()->segment(2) == 'products') ? 'active' : ''  }}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/pricelists') }}" class="nav-link {{ (request()->segment(2) == 'pricelists') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Price List
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/categories') }}" class="nav-link {{ (request()->segment(2) == 'categories') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Categories
              </p>
            </a>
          </li> -->
          @endcan

          <!-- <li class="nav-item">
            <a href="{{ url('admin/orders') }}" class="nav-link {{ (request()->segment(2) == 'orders') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Orders
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/transactions') }}" class="nav-link {{ (request()->segment(2) == 'transactions') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Transactions
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/customers') }}" class="nav-link {{ (request()->segment(2) == 'customers') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Customers
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/advance-payments') }}" class="nav-link {{ (request()->segment(2) == 'advance-payments') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Advance Payment
              </p>
            </a>
          </li> -->

          @can('isAdministrator')
          <li class="nav-item">
            <a href="{{ url('admin/users') }}" class="nav-link {{ (request()->segment(2) == 'users') ? 'active' : ''  }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          @endcan

           @guest
            @if (Route::has('login'))
                <li class="nav-item">
                  <a class="nav-link " href="{{ route('login') }}"><i class="nav-icon fas fa-sign-out-alt"></i>Login</a>
                </li>
            @endif
            
            @else
                <li class="nav-item">
                  <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                       {{ __('Logout') }}
                    </p>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                </li>
            @endguest

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     @yield('content')
  </div>
  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('admin-lte-3.1.0-rc/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin-lte-3.1.0-rc/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin-lte-3.1.0-rc/dist/js/adminlte.min.js') }}"></script>

<!-- Select2  -->
<script src="{{ asset('admin-lte-3.1.0-rc/plugins/select2/js/select2.min.js') }}"></script>

<!-- jquery-ui  -->
<script src="{{ asset('admin-lte-3.1.0-rc/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- table cell edit  -->
<script src="{{ asset('js/jquery-editable-table.min.js') }}"></script>

<!--jquery.mask.js-->
<script src="{{ asset('js/jquery.mask.js') }}"></script>

<!-- Ekko Lightbox -->
<script src="{{ asset('admin-lte-3.1.0-rc/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
<script>
jQuery(document).ready(function(){
  jQuery(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    jQuery(this).ekkoLightbox({
      alwaysShowClose: true
    });
  });

  //jQuery('.filter-container').filterizr({gutterPixels: 3});
  jQuery('.btn[data-filter]').on('click', function() {
    jQuery('.btn[data-filter]').removeClass('active');
    jQuery(this).addClass('active');
  });
});
</script>


<!--custom.js-->
<!-- <script src="{{ asset('js/custom.js') }}"></script> -->


<!--model-->
<div class="modal fade" id="add-item" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Item</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

      <!---->
      <form id="csm_additem_form" method="post" action="http://127.0.0.1/array/csm/demo.php">
        {{ csrf_field() }}
        <div class="card-body=" id="csm_item_append">
          <div class="row">
            <div class="col-8 csm_input_field" id="csm_input_field_0">
              <select class="csm_item_s_key" name="iten_data[0][product_id]" class="form-control"></select>
            </div>
            <div class="col-4">
              <input type="number" name="iten_data[0][qty]" value="1"  class="form-control">
            </div>
          </div>
        </div>
      </form>
      <!---->
       
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_csm_additem_form">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="add-discount" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Discount</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <!---->
        <input type="number" name="discount" id="discount" value="" class="form-control">
        <!---->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_csm_add_discount_form">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="add-shipping" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Shipping</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <!---->
        <input type="number" name="shipping" id="shipping" value="" class="form-control">
        <!---->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_csm_add_shipping_form">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!--end model-->


<script type="text/javascript">
  jQuery(document).ready(function(){

    var now = new Date();
    var dd = now.getDate();
    var mm = now.getMonth() + 1;
    var yy = now.getFullYear();
    var crr_date = `${dd}-${mm}-${yy}`;
    jQuery('#price_date').datepicker({dateFormat: 'dd-mm-yy'});
    jQuery("#price_date").datepicker("setDate", crr_date);
    jQuery("#payment_date").datepicker({dateFormat: 'dd-mm-yy'});


    jQuery("#from_date").datepicker({dateFormat: 'dd-mm-yy'});
    jQuery("#to_date").datepicker({dateFormat: 'dd-mm-yy'});

    jQuery('#product_id2').select2({
        width: '100%',
        placeholder : "Product" 
    });

    jQuery('#customer_id').select2({
        width: '100%',
        placeholder : "Party Name" 
    });

    /*jQuery('#placed_by').select2({
        width: '100%',
        placeholder : "User" 
    });*/

    jQuery('#product_id').select2({
        width: '90%',
        placeholder : "Product" 
    });

  
    jQuery.fn.appendItemInputField = function() {

      var htm = '';
      var count = jQuery('#csm_item_append').find('.csm_input_field').length;
      htm = `
        <div class="row">
          <div class="col-8 csm_input_field" id="csm_input_field_${count}">
            <select class="csm_item_s_key" name="iten_data[${count}][product_id]" class="form-control"></select>
          </div>
          <div class="col-4">
            <input type="number" name="iten_data[${count}][qty]" value="1"  class="form-control">
          </div>
        </div>
      `;
      jQuery('#csm_item_append').append(htm);
    }

    //item search
    jQuery.fn.csm_item_search = function() {
      jQuery('.csm_item_s_key').select2({
        ajax: {
          url: "{{ url('orders/searchitem') }}",
          type: "POST",
          dataType: 'json',
          delay: 250, // delay in ms while typing when to perform a AJAX search
          data: function (params) {  
              return {
                searck_key: params.term, // search query
                _token: "{{ csrf_token() }}",
              };
          },
          processResults: function( data ) {  
            //console.log(data);
            //jQuery("#++").select2('val', '0');
            var options = [];
            if ( data ) {
              jQuery.each( data, function( index, text ) { 
                options.push( { id: text.id, text: text.name  } );
              });
            }
            return {
              results: options
            };
        },
        cache: true
        },
        //minimumInputLength: 3, 
        width: '100%',
        placeholder : "Search for a product..." 
      });

      jQuery('.csm_item_s_key').on('select2:select', function (e) {
        var attr_id = jQuery('.csm_item_s_key').val();
        jQuery(this).appendItemInputField();
        jQuery(this).csm_item_search();
      });
    }
    jQuery(this).csm_item_search();

    //append selected item main fram
    jQuery.fn.csm_item_html = function(res){
      var htm = '';
      if (res.iten_data.length > 0) { //iten_data, items
        jQuery(res.iten_data).each(function(key, val){

          if (val.item_discount != '0') {
            var iprice = `<span style="text-decoration: line-through;">${val.price}</span>  ${val.item_discount_price} `;
          }else{
            var iprice = `<span>${val.price}</span>`;
          }

            htm += `
            <tr id="item_${val.id}" class="items">
                <td>${val.name}
                  <input type="hidden" name="iten_data[${key}][id]" value="${val.id}">
                  <input type="hidden" name="iten_data[${key}][product_id]" value="${val.product_id}">
                </td>

                <td>${iprice} <input type="hidden" name="iten_data[${key}][price]" value="${val.price}"></td>

                <td>
                  <input type="number" class="itemqty" data-prodid="${val.id}" name="iten_data[${key}][qty]" value="${val.qty}" style="width:60px;">
                </td>

                <td>
                  ${val.line_subtotal} <input type="hidden" name="iten_data[${key}][line_subtotal]" value="${val.line_subtotal}">
                </td>

                <td>
                  <span>${val.item_discount}</span>
                  <input type="hidden" name="iten_data[${key}][item_discount]" value="${val.item_discount}" style="width:60px;">
                  <input type="hidden" name="iten_data[${key}][item_discount_price]" value="${val.item_discount_price}" style="width:60px;">
                </td>

                <td>
                  <a href="#" class='csm_remove_item' data-product_id='${val.id}'>X</a>
                </td>
            </tr>
            `;
        });
        jQuery('#csm_items_body').html(htm);
        jQuery('#subtotal_label').text(res.subtotal);
        jQuery('#subtotal').val(res.subtotal);
      }
    }

    //Submit selected items
    jQuery("#csm_additem_form").on('submit',(function(e) { 
      e.preventDefault();
      jQuery.ajax({
        url: "{{ url('orders/additem') }}",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        processData:false,
        beforeSend: function(){
        },
        complete: function(){
        },
        success: function(data){
          console.log('additem: ', data);
          jQuery(this).csm_item_html(data);
          jQuery('#add-item').modal('hide');
        },
        error: function(xhr, status, error) {
          var err = eval("(" + xhr.responseText + ")");
          alert(err.Message);
        }          
      });
    }));
    jQuery(document).on('click', '#btn_csm_additem_form', function (e) {
        e.preventDefault();
        jQuery("#csm_additem_form").submit();
        /*setTimeout(function(){
          jQuery('#csm_item_append').html("");
        }, 500);*/
        
    });
 
    //Remove item
    jQuery(document).on('click', '.csm_remove_item', function (e) {
        e.preventDefault();
        htm = `
          <tr id="item_0" class="items">
              <td>
              <input type="hidden" name="iten_data" value="">
              </td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
          </tr>
          `;
        var product_id = jQuery(this).attr('data-product_id');

        jQuery('#item_'+product_id).remove();

        /*var items_count = jQuery('.items').length;
        if (items_count == 0) {
            jQuery('#csm_items_body').html(htm).hide();
        }*/
    });

    //Add diacount
    jQuery(document).on('click', '#btn_csm_add_discount_form', function (e) {
        e.preventDefault();
        var discount = jQuery('#discount').val();
        var htm = `
            <tr>
              <th>
                Discount <span id="discount_label">${discount}</span>% 
                <a href="#" id="remove_discount">Remove</a> 
                <input type="hidden" name="discount" id="discount" value="${discount}">
              </th>
              <td>
                (-)<span id="discount_price_label">0</span> 
                <input type="hidden" name="discount_price" value="0">
              </td>
            </tr>
        `;
        console.log('discount: ', discount);
        jQuery('#csm_item_discount_body').html(htm).show();
        jQuery('#add-discount').modal('hide');
    });

    //Remove diacount
    jQuery(document).on('click', '#remove_discount', function (e) {
        e.preventDefault();
        var htm = `
          <tr>
            <th>Discount 0% <input type="hidden" name="discount" value="0"></th>
            <td>(-)0 <input type="hidden" name="discount_price" value="0"></td>
          </tr>
        `;
        jQuery('#csm_item_discount_body').html(htm).hide();
        jQuery('#add-discount').modal('hide');

    });

    //Add shipping
    jQuery(document).on('click', '#btn_csm_add_shipping_form', function (e) {
        e.preventDefault();
        var shipping = jQuery('#shipping').val();
        var htm = `
            <tr>
              <th>Shipping <a href="#" id="remove_shipping">Remove</a></th>
              <td><span id="shipping_label">${shipping}</span> <input type="hidden" name="shipping" id="shipping" value="${shipping}"></td>
            </tr>
        `;
       
        console.log('shipping: ', shipping);
        jQuery('#csm_item_shipping_body').html(htm).show();
        jQuery('#add-shipping').modal('hide');
    });

    //Remove shipping
    jQuery(document).on('click', '#remove_shipping', function (e) {
        e.preventDefault();
        var htm = `
            <tr>
              <th>Shipping</th>
              <td>0 <input type="hidden" name="shipping" value="0"></td>
            </tr>
        `;
        jQuery('#csm_item_shipping_body').html(htm).hide();
        jQuery('#add-shipping').modal('hide');
    });

    //Calculate
    jQuery(document).on('click', '#calculate_cart_btn', function(){
      var fd = new FormData();
      var other_data = jQuery('#csm_order_form').serializeArray();
      jQuery.each(other_data,function(key,input){ //_method
          if (input.name != '_method') {
            fd.append(input.name,input.value);
          }else{
            console.log('excluded key _method: ', input.name);
          }
      });
      jQuery.ajax({
        url: "{{ url('orders/calculate_order') }}",
        type: "POST",
        data:  fd,
        contentType: false,
        processData:false,
        beforeSend: function(){
        },
        complete: function(){
        },
        success: function(data){
          console.log('cal: ', data);
          jQuery(this).csm_item_html(data);

          jQuery('#subtotal').val(data.subtotal);
          jQuery('#subtotal_label').text(data.subtotal);

          jQuery('#discount').val(data.discount);
          jQuery('#discount_label').text(data.discount);

          jQuery('#discount_price').val(data.discount_price);
          jQuery('#discount_price_label').text(data.discount_price);

          jQuery('#shipping').val(data.shipping);
          jQuery('#shipping_label').text(data.shipping);

          jQuery('#total').val(data.total);
          jQuery('#total_label').text(data.total);
        },
        error: function(xhr, status, error) {
          var err = eval("(" + xhr.responseText + ")");
          alert(err.Message);
        }          
      });
    });
    //End Calculate

    // Category discount event
    //Product categories
    jQuery.fn.csm_product_category_html = function(res){
      console.log('cat: ', res);
      var cat_htm = "";
      if (res.length > 0) {
        jQuery(res).each(function(key, val){
          cat_htm += `
            <tr>
              <td>${val.name}</td>
              <td><input type="text" name="category_discount[${val.id}]" id="category_discount" value="0"></td>
            </tr>
          `;
        });
      }else{
        cat_htm += `
            <tr>
              <td></td>
              <td>Not Found</td>
            </tr>
          `;
      }
      jQuery('#category_discount_append').html(cat_htm);
    }
    
    jQuery(document).on('click', '#cat_discount_btn', function(e){
      e.preventDefault();
      var target = jQuery(this);
      var fd = new FormData();
      var other_data = jQuery('#csm_order_form').serializeArray();
      jQuery.each(other_data,function(key,input){ //_method
          if (input.name != '_method') {
            fd.append(input.name,input.value);
          }else{
            console.log('excluded key _method: ', input.name);
          }
      });
      jQuery.ajax({
        url: "{{ url('orders/get_product_category') }}",
        type: "POST",
        data:  fd,
        contentType: false,
        processData:false,
        beforeSend: function(){
        },
        complete: function(){
        },
        success: function(data){
          //console.log('cat: ', data);
           jQuery(this).csm_product_category_html(data);
           //jQuery('#add-discount').modal('show');
        },
        error: function(xhr, status, error) {
          var err = eval("(" + xhr.responseText + ")");
          alert(err.Message);
        }          
      });
    });
    // end cat_discount_btn

    //Preview images
    jQuery('.preview_img').change( function(event) {
      var target = jQuery(this);
      var file_url =  URL.createObjectURL(event.target.files[0]);
      console.log(file_url);
      target.next().attr('src',file_url );
    });



    //Aadhar and Pan validation
    jQuery('#pan_no').mask('SSSSS0000S'); //AAAAA0000A
    jQuery('#aadhar_no').mask('0000 0000 0000'); 
    jQuery('#gst_no').mask('00SSSSS0000S0SA'); // 000000000000000
    jQuery('#mobile').mask('0000000000'); // 000000000000000
    jQuery('#mobile_alternate').mask('0000000000'); // 000000000000000

    //confirme befor deletion
    jQuery(document).on('click', '.delete_ev', function(e){
      e.preventDefault();
      var target = jQuery(this);
      var element_id = target.attr('data-element_id');
      if (confirm("Do you want to delete") == true) {
        jQuery('.mydeleteform_'+element_id).submit();
      } else {
      }
    });

    //export btn
    jQuery(document).on('click', '#csm_export_btn', function(e){
      e.preventDefault();
      var target = jQuery(this);
      jQuery('#csm_export_form').submit();
    });


    //bulk delete action
    jQuery(document).on('click', '#selectAll', function(){
      jQuery(this).closest('#table_index').find('td input:checkbox').prop('checked', this.checked);
      if (jQuery(this).is(':checked')) {
        var values = jQuery("input[name='entity_id[]']:checked").map(function(){return jQuery(this).val();}).get();
        jQuery('#entity_ids').val(values);
      }else{
        var values = jQuery("input[name='entity_id[]']:checked").map(function(){return jQuery(this).val();}).get();
        jQuery('#entity_ids').val(values);
      }
      if (jQuery('#entity_ids').val() != '') {
        jQuery('#bulk_delete_action_btn').show();
      }else{
        jQuery('#bulk_delete_action_btn').hide();
      }
    });
    jQuery(document).on('click', '.selectAll', function(){
      if (jQuery(this).is(':checked')) {
        var values = jQuery("input[name='entity_id[]']:checked").map(function(){return jQuery(this).val();}).get();
        jQuery('#entity_ids').val(values);
      }else{
        var values = jQuery("input[name='entity_id[]']:checked").map(function(){return jQuery(this).val();}).get();
        jQuery('#entity_ids').val(values);
      }
      if (jQuery('#entity_ids').val() != '') {
        jQuery('#bulk_delete_action_btn').show();
      }else{
        jQuery('#bulk_delete_action_btn').hide();
      }
    });
    //confirme befor bulk deletion
    jQuery(document).on('click', '#bulk_delete_action_btn', function(e){
      e.preventDefault();
      var target = jQuery(this);
      if (confirm("Do you want to bulk delete") == true) {
        jQuery('#bulk_delete_action_form').submit();
      } else {
      }
    });
    //End bulk delete action


    //Advance paymenr
    jQuery.fn.calculatePaymentWithWallet = function(wallet_amountx, enter_amountx, order_totalx){

        var wallet_amount  = parseFloat(wallet_amountx);
        var enter_amount   = parseFloat(enter_amountx);
        var order_total    = parseFloat(order_totalx);

        var case_mode = 0;
        var case_cond = '';
        var update_wallet = 0;
        var to_pay = 0;
        var balance_amount = 0;

        var diff = order_total - wallet_amount;
        
        //case 1 wallet_amount < order_total
        if(diff > 0){
          update_wallet = 0 * diff;
          to_pay = wallet_amount + enter_amount;
          balance_amount = order_total - to_pay;
          case_mode = 1;
          case_cond = `${wallet_amount} < ${order_total}`;
        }

        //case 2 wallet_amount > order_total
        if(diff < 0){
          update_wallet = -1 * diff;
          to_pay = order_total - enter_amount;
          balance_amount = 0;
          case_mode = 2;
          case_cond = `${wallet_amount} > ${order_total}`;
        }

        //case 3 wallet_amount == order_total
        if(diff == 0){
          update_wallet = 0;
          to_pay = order_total;
          balance_amount = 0;
          case_mode = 3;
          case_cond = `${wallet_amount} == ${order_total}`;
        }


        /*console.log('case: ', case_mode);
        console.log('case: ', case_cond);
        console.log('update_wallet: ', update_wallet);
        console.log('to_pay: ', to_pay);
        console.log('balance_amount: ', balance_amount);*/

        jQuery('#case_mode').text(case_mode);
        jQuery('#case_cond').text(case_cond);

        jQuery('#update_wallet').text(update_wallet);
        jQuery('#to_pay').text(to_pay);
        jQuery('#balance_amount').text(balance_amount);

        jQuery('#update_wallet_x').val(update_wallet);
        jQuery('#to_pay_x').val(to_pay);
        jQuery('#balance_amount_x').val(balance_amount);

        return {
          case_mode: case_mode,
          case_cond: case_cond,
          update_wallet: update_wallet,
          to_pay: to_pay,
          balance_amount: balance_amount
        }
        
    }

    jQuery('#trans_summry').slideUp();

 
    jQuery(document).on('click', '#total_fund_enable', function () {
      var target = jQuery(this);

      jQuery('#paid_amount').val("");

      var wallet_amount  = jQuery('#wallet_amount').val();
      var enter_amount   = (jQuery('#paid_amount').val() != '') ? jQuery('#paid_amount').val() : 0;

      var order_balance_amount = jQuery('#order_balance_amount').val();
      if (order_balance_amount) {
        var order_total    = jQuery('#order_balance_amount').val();
      }else{
        var order_total    = jQuery('#order_total').val();
      }
      
      var act = jQuery(this).calculatePaymentWithWallet(wallet_amount, enter_amount, order_total);

      if(target.is(':checked')){  
        jQuery('#trans_summry').slideDown();
        if (act.case_mode === 2 || act.case_mode === 3) {
          jQuery('#section_payment').slideUp();
        }

        var order_balance_amount = jQuery('#order_balance_amount').val();
        if (order_balance_amount) {
          jQuery('#paid_amount').attr('data-max', order_balance_amount);
        }else{
          jQuery('#paid_amount').attr('data-max', act.balance_amount);
        }

      }else{ 
        jQuery('#trans_summry').slideUp();
        jQuery('#section_payment').slideDown();
        jQuery('#paid_amount').attr('data-max', order_total);
      }

    });

    jQuery(document).on('keyup', '#paid_amount', function () {
      var target = jQuery(this);
      var wallet_amount  = jQuery('#wallet_amount').val();
      var enter_amount   = (target.val() != '') ? target.val() : 0;
      
      var order_balance_amount = jQuery('#order_balance_amount').val();
      if (order_balance_amount) {
        var order_total    = jQuery('#order_balance_amount').val();
      }else{
        var order_total    = jQuery('#order_total').val();
      }
      
      var a = parseFloat(enter_amount);
      var b = parseFloat(jQuery('#paid_amount').attr('data-max'));
      //console.log(a+' == '+b);

      if (a > b && b) {
        alert("Paid amount limit exceeded "+b);
        target.val(b);
      }

    });
    //End Advance paymenr


    

  });


//Aadhar and Pan validation
function ValidatePAN() {
  var txtPANCard = document.getElementById("pan_no");
  var regex = /([A-Z]){5}([0-9]){4}([A-Z]){1}$/;
  if (regex.test(txtPANCard.value.toUpperCase())) { 
      document.getElementById("pan_no_error_msg").style.visibility = "hidden";
      return true;
  } else {
      document.getElementById("pan_no_error_msg").style.visibility = "visible";
      return false;
  }
}
function validateAadhaar(){ 
  var regexp = /^[2-9]{1}[0-9]{3}\s[0-9]{4}\s[0-9]{4}$/; 
  var ano = document.getElementById("aadhar_no").value; 
  if(regexp.test(ano)) { 
    document.getElementById("aadhar_no_error_msg").style.visibility = "hidden";
    return true; 
  }else{ 
    document.getElementById("aadhar_no_error_msg").style.visibility = "visible";
   return false; 
  } 
} 
</script>




<!-- <script>
  var loadFile_pan_no = function(event) {
    var pan_no_img = document.getElementById('pan_no_img');
    pan_no_img.src = URL.createObjectURL(event.target.files[0]);
  };
  var loadFile_aadhar_no = function(event) {
    var aadhar_no_img = document.getElementById('aadhar_no_img');
    aadhar_no_img.src = URL.createObjectURL(event.target.files[0]);
  };
  var loadFile_gst_no = function(event) {
    var gst_no_img= document.getElementById('gst_no_img');
    gst_no_img.src = URL.createObjectURL(event.target.files[0]);
  };
</script> -->



<script type="text/javascript">
/*
*  Custom js
*/
jQuery(document).ready(function(){


  //Get bc plan by menber
  jQuery(document).on('change', '#member_id', function(e) {
    e.preventDefault();
    var target = jQuery(this);

    var member_id = target.find(':selected').val();

    console.log('member_id: ', member_id);

  jQuery.ajax({
    url: "{{ url('payments/get_bc_plan_by_member') }}",
    type: "POST",
    data:  {
        member_id: member_id, // search query
        _token: "{{ csrf_token() }}",
     },
    dataType: 'json',
    //contentType: false,
    //processData:false,
    beforeSend: function(){
    },
    complete: function(){
    },
    success: function(data){

      console.log('data: ', data);
      
    }       
  });
    
  });


});
</script>

</body>
</html>