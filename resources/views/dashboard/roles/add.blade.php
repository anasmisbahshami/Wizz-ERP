@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('role/view') }}">Roles</a></li>
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

<style>
  form.forms-sample #user_select,
  form.forms-sample #role_permissions_select {
    border: 2px solid #727df5;
    padding: 10px 20px;
    margin-bottom: 20px;
    padding-bottom: 0;
  }
</style>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Create a New Role</h6>
        <form method="POST" action="{{ url('role/store') }}" class="forms-sample" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="role_name">Role Name<span style="color:red;"> *</span></label>
            <input required type="text" class="form-control" id="role_name" name="role_name" autocomplete="off" placeholder="e.g. Admin">
            <label class="error mt-2 text-danger" for="role_name">This names role already exists, please choose another one.</label>
          </div>
          <div class="form-group">
            <label for="role_description">Decription</label>
            <input type="text" class="form-control" id="role_description" name="role_description" placeholder="">
          </div>
          <div class="form-group">
            <label for="role_permissions">Select Type <span style="color:red;"> *</span></label>
            <select onchange="myFunction()" required class="js-example-basic-single w-100" id="role_permissions" name="role_permissions[]" multiple="multiple">
              <option disabled>select</option>
              <option value="0">User</option>
              <option value="1">Role</option>
            </select>
          </div>
          <div class="form-group" id="role_permissions_select" style="display: none;">
            <label for="role_permissions">Select Role Permissions <span style="color:red;"> *</span></label>
            <div class="row">
              <div class="col-sm-2">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="permissions[]" value="Add Role">
                    Add Role
                  </label>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="permissions[]" value="View Role">
                    View Role
                  </label>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="permissions[]" value="Edit Role">
                    Edit Role
                  </label>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="permissions[]" value="Delete Role">
                    Delete Role
                  </label>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mr-2">Submit</button>
          <a class="btn btn-light" href="{{ url('role/view') }}">Cancel</a>
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
  function myFunction() {
    $('#role_permissions_select').hide();
    $('#user_select').hide();
    var selectedVals = []
    $("#role_permissions :selected").each(function() {
      selectedVals.push(this.value);
    });
    if (selectedVals.includes("0") && selectedVals.includes("1")) {
      $('#user_select').show();
      $('#role_permissions_select').show();
    }
    else {
      if (selectedVals.includes("0")) {
        $('#user_select').show();
        $('#role_permissions_select').hide();
        $('#role_permissions_select').find('input[type=checkbox]').prop('checked', false);
      }
      if (selectedVals.includes("1")) {
        $('#user_select').hide();
        $('#user_select').find('input[type=checkbox]').prop('checked', false);
        $('#role_permissions_select').show();
      }
      if (!selectedVals.includes("0") && !selectedVals.includes("1")) {
        $('#user_select').find('input[type=checkbox]').prop('checked', false);
        $('#role_permissions_select').find('input[type=checkbox]').prop('checked', false);
      }
    }
  }

  $(document).ready(function() {
    $('.text-danger').hide();
    myFunction();
  });
  $('#role_name').on('blur', function() {
    var rolename = $('#role_name').val();
    if (rolename == '') {
      role_name_state = false;
      $('.text-danger').slideUp(300);
      return;
    }

    $.ajax({
      url: APP_URL + "/role/role_check",
      type: "POST",
      data: {
        "_token": "{{ csrf_token() }}",
        rolename: rolename,
      },
      success: function(response) {
        if (response.success == 'found') {
          $('.text-danger').slideDown(300);
          $(':input[type="submit"]').prop('disabled', true);
        } else {
          $('.text-danger').slideUp(300);
          $(':input[type="submit"]').prop('disabled', false);
        }
      },
      error: function() {

      }
    });
  });
</script>
@endpush