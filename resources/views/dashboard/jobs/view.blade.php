@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

<style>
  .custom:hover{
    color: #E09946 !important;
  }
</style>

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('job/view') }}">Jobs</a></li>
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
              <h6 class="card-title">Jobs List</h6>
            </div>
            @can('Add Job')
              <div class="col-md-6">
                <a href="{{ url('job/add') }}" type="button" class="btn btn-primary" style="float:right;">Add Job</a>
              </div>
            @endcan
          </div>
          <div class="table-responsive pt-3">
            <table id="dataTableExample" class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th class="text-center">
                    Title
                  </th>
                  <th class="text-center">
                    Location
                  </th>
                  <th class="text-center">
                    Total Applicants
                  </th>
                  <th class="text-center">
                    Date Posted
                  </th>
                  <th class="text-center" data-orderable="false">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($jobs as $serial => $job)
                <tr>
                  <td class="text-center">{{ $serial + 1 }}</td>
                  <td class="text-center">{{ $job->title }}</td>
                  <td class="text-center">{{ $job->city->name }}</td>
                  <td class="text-center">{{ $job->applicants->count() }}</td>
                  <td class="text-center">{{ $job->created_at->format('Y-m-d') }}</td>
                  <td class="text-center">  
                      @can('Edit Job')
                        <a title="Edit" href="{{ url('job/edit/'.encrypt($job->id)) }}">
                          <button type="button" class="btn btn-primary btn-icon">
                            <i data-feather="edit"></i>
                          </button>
                        </a>
                      @endcan                  
                      
                      @can('Delete Job')
                        <a title="Delete" data-toggle="modal" data-target="#actionModal{{$serial}}">
                          <button type="button" class="btn btn-primary btn-icon">
                            <i data-feather="trash-2"></i>
                          </button>
                        </a>
                        <div class="modal fade text-left" id="actionModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm your action!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                Are you sure you want to delete this job?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="{{ url('job/destroy/'.encrypt($job->id)) }}" type="button" class="btn btn-primary">Yes</a>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endcan
                      
                      @can('View Job Applicant')
                      @if ($job->applicants->count() > 0)
                      <!-- Button trigger modal -->
                      <a title="Applicants" data-toggle="modal" data-target="#applicantsModal{{$serial}}">
                        <button type="button" class="btn btn-primary">
                          View Applicants
                        </button>
                      </a>
                      <!-- Modal -->
                      <div class="modal fade text-left" id="applicantsModal{{$serial}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Applicants for {{ $job->title }}:</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <ul>
                              @foreach($job->applicants as $applicant)
                                <li style="line-height: 130%;"><a style="color:white;" class="custom" href="{{url('/job/view-applicant/'.encrypt($applicant->id))}}">{{ $applicant->first_name.' '.$applicant->last_name }}</a>@if($applicant->short_listed == 'Yes') (Shortlisted) @endif</li>
                              @endforeach
                            </ul>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif
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