@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('job/view') }}">Job</a></li>
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
          <h6 class="card-title">Post a New Job</h6>
           <form method="POST" action="{{ url('/job/update/'.encrypt($job->id)) }}" class="forms-sample" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label for="title">Title<span style="color:red;"> *</span></label>
                <input required type="text" value="{{$job->title}}" class="form-control" id="title" name="title" autocomplete="off" placeholder="UI/UX Designer">
              </div>
              <div class="form-group col-md-6">
                <label for="role">Location<span style="color:red;"> *</span></label>
                <select required class="js-example-basic-single w-100" id="city_id" name="city_id">
                  <option selected value="">Select</option>
                  @foreach (\App\Models\City::all() as $city)
                      <option @if($job->city_id == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-12">
                <label for="role">Description<span style="color:red;"> *</span></label>
                <textarea required class="form-control" placeholder="Enter Job Description" name="description" id="description" cols="30" rows="5">{{$job->description}}</textarea>
              </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="role">Key Responsibilities<span style="color:red;"> *</span></label>
                        <div class="table-responsive pt-1"  style="overflow-x: clip !important;">
                          <table class="table table-bordered summary">
                            <thead>
                              <tr>
                                <th>Responsibility</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($job->responsibilities as $key => $responsibility)
                                <tr style="width:50px;" class="row_{{$key+1}}">
                                  <td>
                                    <input class="form-control" type="text" value="{{$responsibility->name}}" name="responsibility_name[]">
                                      <div class="text-right mt-0" onclick="remove({{$key+1}})"><button style="margin-top: -10%;" type="button" class="remove_activity btn btn-danger btn-icon">
                                        <i data-feather="x-square"></i>
                                        </button>
                                      </div>
                                  </td>
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                          <center>
                            <button type="button" id="add_label" class="btn btn-success mt-4">Add Responsibility</button>
                          </center>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Update</button>
            <a class="btn btn-light"  href="{{ url('job/view') }}">Cancel</a>
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
    
    $('#add_label').on('click', function(){
      content = '';
      rows = $('.summary tr').length;
      content += '<tr class="row_'+rows+'">';
      content += '<td>';
      content += '<input required class="form-control" type="text" name="responsibility_name[]">';
      content +=      '<div class="text-right mt-0" onclick="remove('+rows+')"><button style="margin-top: -10%;" type="button" class="remove_activity btn btn-danger btn-icon">';
      content +=      '<i data-feather="x-square"></i>';
      content +=      '</button></div>';
      content += '</td>';
      content += '</tr>';
      $('.summary tbody').append(content);
      feather.replace();
    });

    function remove(key){
      $('.row_'+key).remove();
    }
  </script>
@endpush