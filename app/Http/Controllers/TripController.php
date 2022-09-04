<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;

class TripController extends Controller
{
    public function view()
    {
        $trips = Trip::all();
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