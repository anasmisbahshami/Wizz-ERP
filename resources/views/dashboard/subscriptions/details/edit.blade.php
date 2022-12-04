@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('subscription/view') }}">Subscription</a></li>
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
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="text-center mb-3 mt-4">Choose subscription plan!</h4>
          <p class="text-muted text-center mb-4 pb-2">Choose the features and functionality as per your need today. Easily upgrade as your demand grows.</p>

          <div class="container">  
            <div class="row">

            <!-- Subscription Plans -->
            @foreach ($subscriptions as $subscription)
              <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                <div class="card">
                  <div class="card-body" @if ($subscription->id == $IfUserHasSubscription->subscription_id) style="border: 2px solid #E09946" @endif>
                    <h5 class="text-center text-uppercase mt-3 mb-4">{{$subscription->name}}</h5>
                    <i @if($subscription->name == 'Bronze') data-feather="award" @elseif($subscription->name == 'Silver') data-feather="gift" @elseif($subscription->name == 'Gold') data-feather="briefcase" @endif class="text-primary icon-xxl d-block mx-auto my-3"></i>
                    <h3 class="text-center font-weight-light">Rs {{number_format($subscription->price, 0)}}</h3>
                    <p class="text-muted text-center mb-4 font-weight-light">per month</p>
                    <h6 class="text-muted text-center mb-4 font-weight-normal">{{$subscription->description}}</h6>
                    <div class="d-flex align-items-center mb-2">
                      <i data-feather="check" class="icon-md text-primary mr-2"></i>
                      <p>Order Tracking</p>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                      <i data-feather="check" class="icon-md text-primary mr-2"></i>
                      <p>Weight up to {{$subscription->weight}} kg</p>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                      <i data-feather="check" class="icon-md text-primary mr-2"></i>
                      <p>Nation wide delivery</p>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i data-feather="check" class="icon-md text-primary mr-2"></i>
                        <p>30 Days Validation</p>
                    </div>
                    <a @if ($subscription->id == $IfUserHasSubscription->subscription_id) style="background-color: #E09946" @endif href="{{ url('/user/subscribe/'.encrypt($subscription->id)) }}" class="btn btn-primary d-block mx-auto mt-4">@if ($subscription->id == $IfUserHasSubscription->subscription_id) Purchased @else Purchase @endif</a>
                  </div>
                </div>
              </div>
            @endforeach

            </div>
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
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush