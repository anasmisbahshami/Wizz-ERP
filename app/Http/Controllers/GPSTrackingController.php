<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\City;

class GPSTrackingController extends Controller
{
    public function view()
    {
        $InQueue = Trip::where('status','In Queue')->get();
        $Started = Trip::where('status','Started')->get();

        $trips = $InQueue->merge($Started);
        return view('dashboard.gps-tracking.view', compact('trips'));
    }

    public function track($id)
    {
        $id = decrypt($id);
        $trip = Trip::find($id);
        
        //Getting Source & Destination City of Trip
        $sourceCity = City::where('name', $trip->route->source)->first();
        $destinationCity = City::where('name', $trip->route->destination)->first();

        //Checking Trip Status
        if ($trip->status == 'Started') {
            //Origin Latitude of Started Trip
            $origin_latitude = (float)$trip->latitude;
            $origin_longitude = (float)$trip->longitude;            
        }else{
            //Origin Latitude of In Queue Trip
            $origin_latitude = (float)$sourceCity->latitude;
            $origin_longitude = (float)$sourceCity->longitude;
        }

        //Destination Latitude
        $destination_latitude = (float)$destinationCity->latitude;
        $destination_longitude = (float)$destinationCity->longitude;

        return view('dashboard.gps-tracking.track', compact('trip','origin_latitude','origin_longitude','destination_latitude','destination_longitude'));
    }
}