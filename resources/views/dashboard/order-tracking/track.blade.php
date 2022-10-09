@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  
  <style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');body{background-color: #eeeeee;font-family: 'Open Sans',serif}.container{margin-top:50px;margin-bottom: 50px}.card{position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-orient: vertical;-webkit-box-direction: normal;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0, 0, 0, 0.1);border-radius: 0.10rem}.card-header:first-child{border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0}.card-header{padding: 0.75rem 1.25rem;margin-bottom: 0;background-color: #fff;border-bottom: 1px solid rgba(0, 0, 0, 0.1)}.track{position: relative;background-color: #ddd;height: 7px;display: -webkit-box;display: -ms-flexbox;display: flex;margin-bottom: 60px;margin-top: 50px}.track .step{-webkit-box-flex: 1;-ms-flex-positive: 1;flex-grow: 1;width: 25%;margin-top: -18px;text-align: center;position: relative}.track .step.active:before{background: #E09946}.track .step::before{height: 7px;position: absolute;content: "";width: 100%;left: 0;top: 18px}.track .step.active .icon{background: #E09946;color: #fff}.track .icon{display: inline-block;width: 40px;height: 40px;line-height: 40px;position: relative;border-radius: 100%;background: #ddd}.track .step.active .text{font-weight: 400;color: white}.track .text{display: block;margin-top: 7px}.itemside{position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;width: 100%}.itemside .aside{position: relative;-ms-flex-negative: 0;flex-shrink: 0}.img-sm{width: 80px;height: 80px;padding: 7px}ul.row, ul.row-sm{list-style: none;padding: 0}.itemside .info{padding-left: 15px;padding-right: 7px}.itemside .title{display: block;margin-bottom: 5px;color: #212529}p{margin-top: 0;margin-bottom: 1rem}.btn-warning{color: #ffffff;background-color: #E09946;border-color: #E09946;border-radius: 1px}.btn-warning:hover{color: #ffffff;background-color: #E09946;border-color: #E09946;border-radius: 1px}
  </style>
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('order/view') }}">Order</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tracking</li>
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
          <h6 class="card-title">Order Tracking</h6>
          <p style="margin-bottom:12px;">Enter the Tracking ID:</p>
            <div class="form-group">
              <form action="{{ url('/order-track/results') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <input required type="number" class="form-control" name="tracking_id" placeholder="29473497112" value="{{$tracking_id}}">
                    </div>
                    <div class="col-md-4">
                        <button style="margin-top:1px;margin-left:-7px;" type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
   </div>

    <article class="card">
        <div class="card-body">
            <h6 class="mb-2">Tracking ID: {{$order->tracking_code}}</h6>
            <article class="card">
                <div class="card-body row">
                    <div class="col"> <strong>Estimated Delivery time:</strong><br>{{\Carbon\Carbon::parse($order->created_at)->format('d F, Y')}}</div>
                    <div class="col"> <strong>Shipping BY:</strong><br>Wizz Express & Logistics</div>
                    <div class="col"> <strong>Status:</strong><br>{{$order->status}}</div>
                    <div class="col"> <strong>Tracking #:</strong><br>{{$order->tracking_code}}</div>
                </div>
            </article>
            <div class="track">
                <div class="step @if($order->status == 'Confirmed' || $order->status == 'Paid' || $order->status == 'Started' || $order->status == 'In progress' || $order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-check"></i></span><span class="text">Confirmed</span></div>
                <div class="step @if($order->status == 'Paid' || $order->status == 'Started' || $order->status == 'In progress' || $order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-coins"></i></span><span class="text">Paid</span></div>
                <div class="step @if($order->status == 'Started' || $order->status == 'In progress' || $order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-hourglass-start"></i></span><span class="text">Started</span> </div>
                <div class="step @if($order->status == 'In progress' || $order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-truck"></i></span><span class="text">In progress</span></div>
                <div class="step @if($order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-box"></i></span><span class="text">Complete</span></div>
            </div>
        </div>
    </article>

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
@endpush