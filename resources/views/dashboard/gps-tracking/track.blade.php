@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<style>
    #map {
        height: 100%;
    }
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>

  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('gps/view') }}">GPS</a></li>
      <li class="breadcrumb-item active" aria-current="page">Track</li>
    </ol>
  </nav>
  
  <div id="map"></div>

  <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnJmwMUQ_QkQauXOhMiM5Z5myI56iQ2qs&callback=initMap&v=weekly"></script>

<script>
    let map;
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 33.588025837516355, lng: 73.135322842328 },
            zoom: 15,
        });
    }
    window.initMap = initMap;
</script>
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