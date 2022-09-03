@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('route/view') }}">Routes</a></li>
      <li class="breadcrumb-item active" aria-current="page">Add</li>
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
          <h6 class="card-title">Create a New Route</h6>
           <form method="POST" action="{{ url('route/store') }}" class="forms-sample" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label for="name">Name<span style="color:red;"> *</span></label>
                <input required type="text" class="form-control" id="name" name="name" autocomplete="off" placeholder="Islamabad - Karachi">
              </div>
              <div class="form-group col-md-6">
                <label for="email">Rate<span style="color:red;"> *</span></label>
                <input required type="number" step="any" class="form-control" id="rate" name="rate" placeholder="Rs 38,000">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="role">Source<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" id="source" name="source">
                  <option selected value="">Select</option>
                  @foreach (\App\Models\City::all() as $city)
                    <option value="{{ $city->name }}">{{ $city->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="role">Destination<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" id="destination" name="destination">
                  <option selected value="">Select</option>
                  @foreach (\App\Models\City::orderBy('id', 'DESC')->get() as $city)
                    <option value="{{ $city->name }}">{{ $city->name }}</option>
                  @endforeach
                </select>
                @can('Add City')
                <a class="btn btn-link" style="float:right;color:#007bff;text-decoration:underline;" data-toggle="modal" data-target="#CityModal">Can't find your city?</a>
                @endcan
              </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <a class="btn btn-light"  href="{{ url('route/view') }}">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>

  @can('Add City')
  <!-- City Model -->
  <div class="modal fade text-left" id="CityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add City</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('city/store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-md-12">
                  <label for="name">Name<span style="color:red;"> *</span></label>
                  <input required type="text" class="form-control" id="city_name" name="city_name" autocomplete="off" placeholder="Islamabad">
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input style="color:white;" type="submit" value="Yes" class="btn btn-primary">
        </div>
        </form>
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