@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('vehicle/view') }}">Vehicle</a></li>
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
          <h6 class="card-title">Create a New Vehicle</h6>
           <form method="POST" action="{{ url('vehicle/store') }}" class="forms-sample" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-4">
                <label for="name">Name<span style="color:red;"> *</span></label>
                <input required type="text" class="form-control" id="name" name="name" autocomplete="off" placeholder="ISUZU-7160">
              </div>
              <div class="form-group col-md-4">
                <label for="email">Reg No.<span style="color:red;"> *</span></label>
                <input required type="text" class="form-control" id="number_plate" name="number_plate" placeholder="ISB-6532">
              </div>
              <div class="form-group col-md-4">
                <label for="email">GPS ID</label>
                <input type="text" class="form-control" id="gps_id" name="gps_id" placeholder="GPS-6780">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="role">Ownership<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" id="ownership" name="ownership">
                  <option selected value="">Select</option>
                  <option value="Company">Company</option>
                  <option value="Vendor">Vendor</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="role">Vehicle Type<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" id="type" name="type">
                  <option selected value="">Select</option>
                  <option value="HTV">HTV</option>
                  <option value="LTV">LTV</option>
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <a class="btn btn-light"  href="{{ url('vehicle/view') }}">Cancel</a>
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
@endpush