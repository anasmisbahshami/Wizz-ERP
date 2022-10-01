@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('order/view') }}">Order</a></li>
      <li class="breadcrumb-item active" aria-current="page">Details</li>
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
          <div class="row">
            <div class="col-md-6">
              <h6 class="card-title">Order Items</h6>
            </div>
            @if (!empty($order->paid_invoice))
            <div class="col-md-6">
              <a href="{{ url('/order/paid/invoice/'.encrypt($order->id)) }}" type="button" class="btn btn-success" style="float:right;">Paid Invoice</a>
            </div>
            @endif
          </div>
          <div class="table-responsive pt-3">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center">Name</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-center">Vehicle</th>
                  <th class="text-center">Route</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Weight</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->items as $serial => $item)
                <tr>
                  <td class="text-center">{{ $item->name }}</td>
                  <td class="text-center">{{ $item->quantity }}</td>
                  <td class="text-center">{{ \App\Models\Vehicle::find($item->vehicle_id)->name }}</td>
                  <td class="text-center">{{ \App\Models\Route::find($item->route_id)->name }}</td>
                  <td class="text-center">Rs {{ number_format($item->price, 2) }}</td>
                  <td class="text-center">{{ number_format($item->weight, 2) }} Kg</td>
                </tr>                    
                @endforeach
                <tr>
                  <td colspan="3" style="border:none;"></td>
                  <td style="font-weight: bold;" class="text-center">Total</td>
                  <td class="text-center">Rs {{ number_format($order->items->sum('price'), 2) }}</td>
                  <td class="text-center">{{ number_format($order->items->sum('weight'), 2) }} Kg</td>
                </tr>
              </tbody>
            </table>
          </div>
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
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush