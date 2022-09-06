@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <style>
    .sub-head{
       text-align:center;
       background-color:#838383;
       border: 1px solid #444444      
    }
  </style>
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('order/view') }}">Order</a></li>
      <li class="breadcrumb-item active" aria-current="page">Book</li>
    </ol>
  </nav>

  @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
  </div>
  @endif
  
  @if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Warning!</strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Order Booking</h6>
          <p style="margin-bottom:12px;">What Type of order are you going to use for booking?</p>
        <!-- Radio Buttons-->
            <div class="form-group">
              <div style="margin-bottom:12px;" class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="order_type" value="normal" onclick="OrderType(this.value)">
                  Normal Order
                </label>
              </div>
              <div style="margin-bottom:28px;" class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="order_type" value="subscription" onclick="OrderType(this.value)">
                  Subscription
                </label>
              </div>
            </div>
        <!-- Email Subscription Order-->
            <div id="EmailField" class="form-group" style="display: none;">
                <label for="exampleInputEmail3">Enter Email</label>
                <div class="row">
                    <div class="col-md-4">
                        <input type="email" class="form-control" name="subscription_email" placeholder="Enter Email">
                    </div>
                    <div class="col-md-4">
                        <button style="margin-top:1px;margin-left:-7px;" type="button" onclick="ShowSubscriptionDetail()" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
            <!-- Email Normal Order-->
            <div id="EmailFieldNormal" class="form-group" style="display: none;">
                <label for="exampleInputEmail3">Enter Email</label>
                <div class="row">
                    <div class="col-md-4">
                        <input type="email" class="form-control" name="normal_email" placeholder="Enter Email">
                    </div>
                    <div class="col-md-4">
                        <button style="margin-top:1px;margin-left:-7px;" type="button" onclick="ShowNormalDetail()" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
   </div>

   <div id="SubscriptionTable" class="row" style="display: none;">
    <div class="col-lg-12 stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Subscription Details</h6>
        <!-- Subscription Table-->
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="sub-head" style="color:white;">Subscription</th>
                  <th class="sub-head" style="color:white;">Remaining Weight</th>
                  <th class="sub-head" style="color:white;">Valid Upto</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td id="SubscriptionName" style="text-align:center;"></td>
                  <td id="SubscriptionRemainingWeight" style="text-align:center;"></td>
                  <td id="SubscriptionValidUpto" style="text-align:center;"></td>
                </tr>
              </tbody>
            </table>
          </div>
        <!-- Place Order Button-->
        <div id="PlaceOrderButton"></div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>

  <script>
    function OrderType(value){
        if (value == 'normal') {
            $('#EmailField').hide();
            $('#SubscriptionTable').hide();
            $('#EmailFieldNormal').show();
        } else {
            $('#EmailFieldNormal').hide();
            $('#EmailField').show();
        }
    }

    function ShowNormalDetail(){
       var email = $('input[name="normal_email"]').val();

       $.post('{{ route('getNormalDetails') }}', {_token:'{{ csrf_token() }}', email:email}, function(data){
        if(data.success == true){
            window.location.replace(APP_URL+'/order-book/add/'+data.user_id);
        }else{
            alert(data.msg);
            }
        }); 
    }

    function ShowSubscriptionDetail(){
       var email = $('input[name="subscription_email"]').val();
        
       $.post('{{ route('getSubscriptionDetails') }}', {_token:'{{ csrf_token() }}', email:email}, function(data){
        if(data.success == true){
            $('#SubscriptionTable').show();
            $('#SubscriptionName').text(data.subscription);
            $('#SubscriptionRemainingWeight').text(data.remaining_weight + ' '+'kg');
            $('#SubscriptionValidUpto').text(data.vaild_upto);

        if (data.remaining_weight > 0 && data.valid_upto_result) {
            $('#PlaceOrderButton').show();
            $('#PlaceOrderButton').html(
                '<a href="/order-book/add/'+data.user_id+'" style="background-color: #838383;color:white;" class="btn mt-4" class="btn btn-icon-text"><i class="btn-icon-prepend" data-feather="check-square"></i>Place Order</a>'
            );  
        }else{
            $('#PlaceOrderButton').show();
            $('#PlaceOrderButton').html(
                '<button disabled style="background-color: #838383;color:white;pointer-events: none;" class="btn mt-4" class="btn btn-icon-text"><i class="btn-icon-prepend" data-feather="check-square"></i>Place Order</button>'
            );
            alert('Your Subscription is not compatible for placing order!')
        }
    }else{
        $('#SubscriptionTable').hide();
        $('#PlaceOrderButton').hide();
          alert(data.msg);
        }
    });
    }
  </script>

@endpush