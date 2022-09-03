<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\City;

class RouteController extends Controller
{
    public function view()
    {
        $routes = Route::all();
        return view('dashboard.routes.view', compact('routes'));
    }

    public function create()
    {
        return view('dashboard.routes.add');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        Route::create($input);

        return redirect('route/view')->with('success','New Route has been added.');
    }

    public function city_store(Request $request)
    {
        $city = new City();
        $city->name = $request->city_name;
        $city->save();

        return redirect('route/add')->with('success','New City has been added.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $route = Route::find($id);

        return view('dashboard.routes.edit', compact('route'));
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $input = $request->except('_token');

        Route::find($id)->update($input);
        
        return redirect('route/view')->with('success','Route has been updated.');
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        Route::find($id)->delete();

        return back()->with('success','Route has been deleted');
    }
}