@extends('layouts.admin')

@section('content')

<style type="text/css">
a.pre_item {
    float: right;
}

@media screen {
  
}
@media print {

  @page{ 
      size: auto; /* auto is the initial value */ 
      /* this affects the margin in the printer settings */ 
      margin: 15mm 20mm 15mm 20mm;  /*top left bottom right*/
  } 

  body{ 
      /* this affects the margin on the content before sending to printer */ 
      /*margin: 0px;  */
  }

  footer.main-footer {
      display: none;
  }
  .pre_itemx {
      display: none;
  }
  aside.main-sidebar.sidebar-dark-primary.elevation-4{
    display: none;
  }
  nav.main-header.navbar.navbar-expand.navbar-white.navbar-light{
    display: none;
  }
  a.btn.btn-primary.back-btn {
      display: none;
  }
  
}
</style>
<script type="text/javascript">
  function printDiv(divName) {
    window.print();
  }
</script>


<div class="content-header"></div>
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Customer Details</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">

        <div class="card-body table-responsive p-0">

          <div class="form-group">
            <a class="btn btn-primary back-btn" href="{{ URL::previous() }}">Go Back</a>
          </div>

          <div class="form-group pre_itemx">
            <a class="pre_item" href="javascript://" onclick="printDiv('printableArea')">Print</a>
          </div>

          <div class="form-group">
            <table class="table table-hover text-nowrap">
                <tbody>
                  <tr>
                    <th>Client Name</th>
                    <td>{{$customer->name}}</td>
                  </tr>
                  <tr>
                    <th>Company Name</th>
                    <td>{{$customer->company_name}}</td>
                  </tr>
                  @if($crr_user->user_type == 'administrator')
                  <tr>
                    <th>Credit Limit</th>
                    <td>{{$customer->credit_limit}}</td>
                  </tr>
                  @endif
                  <tr>
                    <th>Billing Address</th>
                    <td>{{$customer->address}}</td>
                  </tr>
                  <tr>
                    <th>Mobile</th>
                    <td>{{$customer->mobile}}</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>{{$customer->email}}</td>
                  </tr>
                  <tr>
                    <th>Profile Image</th>
                    <td>
                      @if ($customer->profile_image!='')
                        <a href="{{url($customer->profile_image)}}" data-toggle="lightbox" data-title="Profile Image" data-gallery="gallery">
                           <img src="{{url($customer->profile_image)}}" id="pan_no_img" style="width: 20%;" />
                        </a>
                      @else
                        <img src="" id="pan_no_img" style="width: 20%;" />
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>PAN Card No.</th>
                    <td>{{$customer->pan_no}}</td>
                  </tr>
                  <tr>
                    <th>PAN Card Front Image</th>
                    <td>
                      @if ($customer->pan_no_front_img!='')
                        <a href="{{url($customer->pan_no_front_img)}}" data-toggle="lightbox" data-title="PAN Card Front Image" data-gallery="gallery">
                           <img src="{{url($customer->pan_no_front_img)}}" id="pan_no_img" style="width: 20%;" />
                        </a>
                       @else
                        <img src="" id="pan_no_img" style="width: 20%;" />
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Aadhar Card No</th>
                    <td>{{$customer->aadhar_no}}</td>
                  </tr>
                  <tr>
                    <th>Aadhar Card Front Image</th>
                    <td>
                      @if ($customer->aadhar_no_front_img!='')
                        <a href="{{url($customer->aadhar_no_front_img)}}" data-toggle="lightbox" data-title="Aadhar Card Front Image" data-gallery="gallery">
                            <img src="{{url($customer->aadhar_no_front_img)}}" id="pan_no_img" style="width: 20%;" />
                        </a>
                       @else
                        <img src="" id="pan_no_img" style="width: 20%;" />
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Aadhar Card Back Image</th>
                    <td>
                      @if ($customer->aadhar_no_back_img!='')
                        <a href="{{url($customer->aadhar_no_back_img)}}" data-toggle="lightbox" data-title="Aadhar Card Back Image" data-gallery="gallery">
                             <img src="{{url($customer->aadhar_no_back_img)}}" id="pan_no_img" style="width: 20%;" />
                        </a>
                       @else
                        <img src="" id="pan_no_img" style="width: 20%;" />
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>GST No</th>
                    <td>{{$customer->gst_no}}</td>
                  </tr>
                  <tr>
                    <th>GST Front Image</th>
                    <td>
                      @if ($customer->gst_no_front_img!='')
                      <a href="{{url($customer->gst_no_front_img)}}" data-toggle="lightbox" data-title="GST Front Image" data-gallery="gallery">
                            <img src="{{url($customer->gst_no_front_img)}}" id="pan_no_img" style="width: 20%;" />
                        </a> 
                      @else
                        <img src="" id="pan_no_img" style="width: 20%;" />
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Gst Back Image</th>
                    <td>
                      @if ($customer->gst_no_back_img!='')
                      <a href="{{url($customer->gst_no_back_img)}}" data-toggle="lightbox" data-title="Gst Back Image" data-gallery="gallery">
                          <img src="{{url($customer->gst_no_back_img)}}" id="pan_no_img" style="width: 20%;" />
                      </a> 
                      @else
                        <img src="" id="pan_no_img" style="width: 20%;" />
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Gst Third Image</th>
                    <td>
                      @if ($customer->gst_no_third_img!='')
                        <a href="{{url($customer->gst_no_third_img)}}" data-toggle="lightbox" data-title="Gst Third Image" data-gallery="gallery">
                          <img src="{{url($customer->gst_no_third_img)}}" id="pan_no_img" style="width: 20%;" />
                        </a> 
                       @else
                        <img src="" id="pan_no_img" style="width: 20%;" />
                      @endif
                    </td>
                  </tr>

                  @if(is_object($customer->user))
                  <tr>
                    <th>Sales Persones</th>
                    <td>{{$customer->user->name}}</td>
                  </tr>
                  @endif

                </tbody>
              </table>
          </div>

        </div>


        




      

      
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection