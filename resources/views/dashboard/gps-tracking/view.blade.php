@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('gps/view') }}">GPS</a></li>
      <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
  </nav>
  
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h6 class="card-title">Active Vehicles</h6>
            </div>
          </div>
          <div class="table-responsive pt-3">
            <table id="dataTableExample" class="table table-hover">
              <thead>
                <tr>
                  <th>
                    #
                  </th>
                  <th>
                    Vehicle
                  </th>
                  <th>
                    Route
                  </th>
                  <th>
                    Driver
                  </th>
                  <th>
                    Nature
                  </th>
                  <th>
                    Date
                  </th>
                  @can('Track GPS')
                  <th class="text-center" data-orderable="false">
                    Actions
                  </th>
                  @endcan
                </tr>
              </thead>
              <tbody>
                @foreach($trips as $serial => $trip)
                <tr>
                  <td>{{ $serial + 1 }}</td>
                  <td>{{ $trip->vehicle->name }}</td>
                  <td>{{ $trip->route->name }}</td>
                  <td>{{ $trip->vehicle->driver->name }}</td>
                  <td>{{ $trip->vehicle->type }}</td>
                  <td>{{ \Carbon\Carbon::parse($trip->date)->format('d M Y') }}</td>
                  <td class="text-center">
                      @can('Track GPS')
                        <a title="Track" href="{{ url('gps/track/'.encrypt($trip->id)) }}">
                          <button type="button" class="btn btn-primary btn-icon">
                            <i data-feather="eye"></i>
                          </button>
                        </a>
                      @endcan
                  </td>
                </tr>
                @endforeach
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
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush