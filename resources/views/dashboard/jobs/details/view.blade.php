@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('job/view') }}">Job Applicant</a></li>
      <li class="breadcrumb-item active" aria-current="page">View</li>
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
            <div class="row">
                <div class="col-md-6">
                    <h6 class="card-title">Applicant Details</h6>
                </div>
                <div class="col-md-6">
                    @can('Delete Job Applicant')
                    <a title="Delete" data-toggle="modal" data-target="#DeleteApplicantModel" style="float:right;">
                      <button style="height: 30px;" type="button" class="btn btn-danger btn-icon">
                        <i data-feather="trash"></i>
                      </button>
                    </a>
                    <div class="modal fade text-left" id="DeleteApplicantModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              Are you sure you want to delete this job applicant?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <a href="{{ url('/job/applicant-delete/'.encrypt($job_applicant->id)) }}" type="button" class="btn btn-primary">Yes</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endcan
                    <a href="{{ url('/job/applicant-resume/'.encrypt($job_applicant->id)) }}" type="button" class="btn btn-success" style="float:right;margin-right:4px;">Download Resume</a>
                </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="title">First Name<span style="color:red;"> *</span></label>
                <input readonly type="text" class="form-control" id="title" name="title" autocomplete="off" value="{{$job_applicant->first_name}}">
              </div>
              <div class="form-group col-md-6">
                <label for="title">Last Name<span style="color:red;"> *</span></label>
                <input readonly type="text" class="form-control" id="title" name="title" autocomplete="off" value="{{$job_applicant->last_name}}">
              </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                  <label for="title">Email<span style="color:red;"> *</span></label>
                  <input readonly type="text" class="form-control" id="title" name="title" autocomplete="off" value="{{$job_applicant->email}}">
                </div>
                <div class="form-group col-md-6">
                  <label for="title">Phone<span style="color:red;"> *</span></label>
                  <input readonly type="text" class="form-control" id="title" name="title" autocomplete="off" value="{{$job_applicant->phone}}">
                </div>
            </div>
            
            <div class="row">
              <div class="form-group col-md-12">
                <label for="role">Address<span style="color:red;"> *</span></label>
                <textarea readonly class="form-control" placeholder="Enter Job Description" cols="30" rows="5">{{$job_applicant->address}}</textarea>
              </div>
            </div>

            @can('Shortlist Job Applicant')
            <button type="button" data-toggle="modal" data-target="#shortListModal" class="btn btn-primary mr-2">Shortlist</button>                      
            <!-- Modal -->
            <div class="modal fade text-left" id="shortListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Short list for Interview:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{url('/job/shortlist-applicant/'.encrypt($job_applicant->id))}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                        <label for="title">Meeting Link<span style="color:red;"> *</span></label>
                        <input required type="text" class="form-control" id="title" name="meeting_link" autocomplete="off" placeholder="https://meet.google.com/qkz-spbb-xnm">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                          <label for="role">Message<span style="color:red;"> *</span></label>
                          <textarea required class="form-control" placeholder="" name="email_message" cols="30" rows="5">Hello, {{$job_applicant->first_name}} you've been shortlisted for the role of {{$job_applicant->job->title}} at Wizz Express & Logistics.<br>
                          Please Join the meeting link at 21:00 (PST).
                        </textarea>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Email</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            @endcan
            <a class="btn btn-light"  href="{{ url('job/view') }}">Cancel</a>
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
    CKEDITOR.replace( 'email_message' );
  </script>
@endpush