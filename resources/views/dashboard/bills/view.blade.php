@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <style>
     .datepicker.input-group .input-group-addon {
        padding: 0 10px;
        border-left: none !important;
        display: flex;
        align-items: center;
      }
    </style>
@endpush

@section('content')
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
    
    @can('Generate Monthly Bill')
    <div class="mb-3" style="text-align: center;">
        <h4>Bill Statement - Monthly</h4>
    </div>
    
    <div class="row">
      <div class="col-xl-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
          <form action="{{ url('bill/generate/monthly/statement') }}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                      <label>Month<span style="color:red;"> *</span></label>
                      <select required id="MonthlyMonth" name="month" class="js-example-basic-single w-100">
                      <option value="">Select</option>
                      <option value="1">January</option>
                      <option value="2">February</option>
                      <option value="3">March</option>
                      <option value="4">April</option>
                      <option value="5">May</option>
                      <option value="6">June</option>
                      <option value="7">July</option>
                      <option value="8">August</option>
                      <option value="9">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Year<span style="color:red;"> *</span></label>
                      <select required id="MonthlyYear" name="year" class="js-example-basic-single w-100">
                      <option value="">Select</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Vehicle</label>
                      <select id="vehicle_id" name="vehicle_id" class="js-example-basic-single w-100">
                      <option value="">Default</option>
                      @foreach (\App\Models\Vehicle::all() as $vehicle)
                        <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <button style="margin-top: 30px;" type="submit" class="btn btn-primary">Generate</button>
                  </div>
              </div>
          </form>
            </div>
          </div>
        </div>
      </div>
    @endcan

    @can('Generate Monthly Range Bill')
      <div class="mb-3" style="text-align: center;">
        <h4>Bill Statement - Monthly Range</h4>
      </div>
    
    <div class="row">
      <div class="col-xl-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
          <form action="{{url('bill/generate/monthly/range/statement')}}" method="POST" enctype="multipart/form-data">
            @csrf
              <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                      <label>Starting Month<span style="color:red;"> *</span></label>
                      <select required id="MonthlyStartingMonth" name="starting_month" class="js-example-basic-single w-100">
                      <option value="">Select</option>
                      <option value="1">January</option>
                      <option value="2">February</option>
                      <option value="3">March</option>
                      <option value="4">April</option>
                      <option value="5">May</option>
                      <option value="6">June</option>
                      <option value="7">July</option>
                      <option value="8">August</option>
                      <option value="9">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Ending Month<span style="color:red;"> *</span></label>
                      <select required id="MonthlyEndingMonth" name="ending_month" class="js-example-basic-single w-100">
                      <option value="">Select</option>
                      <option value="1">January</option>
                      <option value="2">February</option>
                      <option value="3">March</option>
                      <option value="4">April</option>
                      <option value="5">May</option>
                      <option value="6">June</option>
                      <option value="7">July</option>
                      <option value="8">August</option>
                      <option value="9">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Year<span style="color:red;"> *</span></label>
                      <select required id="MonthlyRangeYear" name="year" class="js-example-basic-single w-100">
                      <option value="">Select</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Vehicle</label>
                      <select id="vehicle" name="vehicle_id" class="js-example-basic-single w-100">
                      <option value="">Default</option>
                      @foreach (\App\Models\Vehicle::all() as $vehicle)
                        <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                      @endforeach
                      </select>
                    </div>
                  </div>
                    <div class="col-md-2">
                      <button style="margin-top: 30px;" type="submit" class="btn btn-primary">Generate</button>
                    </div>
              </div>
          </form>
            </div>
          </div>
        </div>
      </div>
    @endcan


    @can('Generate Date Range Bill')
    <div class="mb-3" style="text-align: center;">
      <h4>Bill Statement - Date Range</h4>
    </div>
  
  <div class="row">
    <div class="col-xl-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
        <form action="{{url('bill/generate/date/range/statement')}}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Starting Date<span style="color:red;"> *</span></label>
                    <div class="input-group date datepicker" id="datePickerExample">
                      <input required value="{{ \Carbon\Carbon::now()->subMonth(1)->format('Y-m-d') }}" type="text" name="starting_date" class="form-control"><span class="input-group-addon"><i style="color:#E09946" data-feather="calendar"></i></span>
                  </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Ending Date<span style="color:red;"> *</span></label>
                    <div class="input-group date datepicker" id="datePickerExample">
                      <input required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" type="text" name="ending_date" class="form-control"><span class="input-group-addon"><i style="color:#E09946" data-feather="calendar"></i></span>
                  </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Vehicle</label>
                    <select id="vehicle" name="vehicle_id" class="js-example-basic-single w-100">
                    <option value="">Default</option>
                    @foreach (\App\Models\Vehicle::all() as $vehicle)
                      <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                    @endforeach
                    </select>
                  </div>
                </div>
                  <div class="col-md-2">
                    <button style="margin-top: 30px;" type="submit" class="btn btn-primary">Generate</button>
                  </div>
            </div>
        </form>
          </div>
        </div>
      </div>
    </div>
  @endcan

@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush