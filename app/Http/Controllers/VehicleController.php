<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function view()
    {
        $vehicles = Vehicle::all();
        return view('dashboard.vehicles.view', compact('vehicles'));
    }

    public function create()
    {
        return view('dashboard.vehicles.add');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        Vehicle::create($input);

        return redirect('vehicle/view')->with('success','New Vehicle has been added.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $vehicle = Vehicle::find($id);

        return view('dashboard.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $input = $request->except('_token');

        Vehicle::find($id)->update($input);
        
        return redirect('vehicle/view')->with('success','Vehicle has been updated.');
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        Vehicle::find($id)->delete();

        return back()->with('success','Vehicle has been deleted');
    }
}