<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if(\Auth::user()->hasAnyRole(['Super Admin','Admin'])){
            $start_date = Carbon::now()->subMonth(1)->format('d-F-Y');
            $end_date = Carbon::now()->format('d-F-Y');
            return view('dashboard.dashboard', compact('start_date', 'end_date'));
        }else{
            return redirect('/profile/view');
        }
    }
}
