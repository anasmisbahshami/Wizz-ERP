<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;

class GPSTrackingController extends Controller
{
    public function view()
    {
        $trips = Trip::where('status', 'In Progress')->get();
        return view('dashboard.gps-tracking.view', compact('trips'));
    }

    public function track($id)
    {
        $id = decrypt($id);
        $trip = Trip::find($id);
        return view('dashboard.gps-tracking.track', compact('trip'));
    }
}