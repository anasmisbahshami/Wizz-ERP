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

  <script src="{{ asset('js/app.js') }}"></script>

  @php $vehicle = $trip->vehicle->name @endphp

  <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnJmwMUQ_QkQauXOhMiM5Z5myI56iQ2qs&callback=initMap&v=weekly"></script>
  

<script>
  var vehicle = @json($vehicle);

    let map;
    let origin = { lat: 33.588025837516355, lng: 73.135322842328 };
    let destination = { lat: 31.558, lng: 74.3507 };
    let tripCoordinates;
    let OriginMarker;
    let DestinationMarker;
    let tripPath;

    function initMap() {

      //Intializing Map
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 6,
        center: origin,
      });
      
      //Setting Origin Marker
      OriginMarker = new google.maps.Marker({
        position: origin,
        map,
        title: vehicle,
      });

      //Setting Destination Marker
      DestinationMarker = new google.maps.Marker({
        position: destination,
        map,
      });

      //Origin & Destination Coordinates
      tripCoordinates = [
        origin,
        destination,
      ];

      //Setting Polyline from Origin to Destination
      tripPath = new google.maps.Polyline({
        path: tripCoordinates,
        geodesic: true,
        strokeColor: "#FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 1.5,
      });

      tripPath.setMap(map);

    }
      // window.initMap = initMap;

    //Update Marker Position
    function updatePosition(newlat, newlng){
      
      //Setting Polyline to Null
      tripPath.setMap(null);

      const updatedOrigin = { lat: newlat, lng: newlng};
      OriginMarker.setPosition(updatedOrigin);
      map.setCenter(updatedOrigin);

      //Updated Origin & Destination Coordinates
      tripCoordinates = [
        updatedOrigin,
        destination,
      ];

      //Setting Polyline from Updated Origin to Destination
      tripPath = new google.maps.Polyline({
        path: tripCoordinates,
        geodesic: true,
        strokeColor: "#FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 1.5,
      });

      tripPath.setMap(map);

    }

    //Capturing Event Fired Pusher
    Echo.channel('Wizz-ERP').listen('VehicleMoved', (e) => {
      console.log(e);
      updatePosition(e.lat, e.lng);
    });

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