@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('trip/view') }}">Trip</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
  
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Edit Trip</h6>
           <form method="POST" action="{{ url('trip/update/'.encrypt($trip->id)) }}" class="forms-sample" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label for="email">Vehicle<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" id="vehicle_id" name="vehicle_id">
                    <option selected value="">Select</option>
                    @foreach(\App\Models\Vehicle::all() as $vehicle)
                        <option @if ($trip->vehicle_id == $vehicle->id) selected @endif value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="name">Route<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" onchange="getRate()" id="route_id" name="route_id">
                    <option selected value="">Select</option>
                    @foreach(\App\Models\Route::all() as $route)
                        <option @if ($trip->route_id == $route->id) selected @endif value="{{ $route->id }}">{{ $route->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            <div class="row">
            <div class="form-group col-md-6">
                <label for="email">Rate<span style="color:red;"> *</span></label>
                <input required readonly value="{{ $trip->rate }}" type="number" step="any" class="form-control" id="rate" name="rate" placeholder="Rs 10,000">
            </div>
              <div class="form-group col-md-6">
                <label for="role">Date<span style="color:red;"> *</span></label>
                <div class="input-group date datepicker" id="datePickerExample">
                <input required type="text" value="{{ $trip->date }}" name="date" id="date" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Update</button>
            <a class="btn btn-light"  href="{{ url('trip/view') }}">Cancel</a>
          </form>
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
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script>
    function getRate(){
        var vehicle_id = $('#vehicle_id').val();
        var route_id = $('#route_id').val();

        $.post('{{ route('getRate') }}', {_token:'{{ csrf_token() }}', vehicle_id:vehicle_id, route_id:route_id}, function(data){
        if(data){        
            $('#rate').val(data);
        }
        });
    }
  </script>
@endpush