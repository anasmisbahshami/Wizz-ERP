<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Location;

class TripController extends Controller
{
    public function view()
    {
        $InQueue = Trip::where('status','In Queue')->get();
        $Started = Trip::where('status','Started')->get();
        $Completed = Trip::where('status','Completed')->get();

        $trips = $InQueue->merge($Started);
        $trips = $trips->merge($Completed);

        return view('dashboard.trips.view', compact('trips'));
    }

    public function create()
    {
        return view('dashboard.trips.add');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        Trip::create($input);

        return redirect('trip/view')->with('success','New Trip has been added.');
    }

    public function get_rate(Request $request)
    {
        $vehicle = \App\Models\Vehicle::find($request->vehicle_id);
        $route = \App\Models\Route::find($request->route_id);
        
        if ($vehicle->type == 'HTV') {
            $rate = $route->rate;
        }else{
            $rate = ($route->rate)/2.5;
        }

        return $rate;
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $trip = Trip::find($id);

        return view('dashboard.trips.edit', compact('trip'));
    }

    public function complete($id)
    {
        $id = decrypt($id);
        $trip = Trip::find($id);
        $trip->status = 'Completed';
        $trip->notify_start = 0;
        $trip->notify_complete = 1;
        $trip->save();

        return redirect()->back()->with('success', 'Trip Marked as Completed!');
    }

    public function start($id)
    {
        $id = decrypt($id);
        $trip = Trip::find($id);

        //Getting IP Address of User
        $ipaddress = '';
        
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = '127.0.0.1';

        //Getting Latitude and Longitude from IP
        if($ipaddress != '127.0.0.1') {
            $location = Location::get($ipaddress);
            $locationArray = json_decode(json_encode($location), true);
            $latitude = $locationArray['latitude'];
            $longitude = $locationArray['longitude'];
        }else{
            $latitude = 33.6665;
            $longitude = 73.0516;
        }

        //Updating Latitude, Longitude & Status of Trip
        $trip->latitude = $latitude;
        $trip->longitude = $longitude;
        $trip->status = 'Started';
        $trip->notify_start = 1;
        $trip->save();

        return redirect()->back()->with('success', 'Trip Marked as Started!');
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $input = $request->except('_token');

        Trip::find($id)->update($input);
        
        return redirect('trip/view')->with('success','Trip has been updated.');
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        Trip::find($id)->delete();

        return back()->with('success','Trip has been deleted');
    }

    public function acknowledge($id)
    {
        $id = decrypt($id);
        Trip::find($id)->update([
            "notify_start" => '0',
            "notify_complete" => '0'
        ]);

        return back()->with('success','Trip Acknowledged');
    }

}