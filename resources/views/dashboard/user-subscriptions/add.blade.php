@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('user-subscription/view') }}">User Subscription</a></li>
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
          <h6 class="card-title">Create a New User Subscription</h6>
           <form method="POST" action="{{ url('user-subscription/store') }}" class="forms-sample" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                  <label for="role">User<span style="color:red;"> *</span></label>
                  <select required class="js-example-basic-single w-100" id="user_id" name="user_id">
                    <option selected value="">Select</option>
                    @foreach (\App\Models\User::all() as $user)
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="role">Subscription<span style="color:red;"> *</span></label>
                  <select required class="js-example-basic-single w-100" id="subscription_id" name="subscription_id">
                    <option selected value="">Select</option>
                    @foreach (\App\Models\Subscription::all() as $subscription)
                      <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <a class="btn btn-light"  href="{{ url('user-subscription/view') }}">Cancel</a>
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