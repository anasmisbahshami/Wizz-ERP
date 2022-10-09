<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function view()
    {
        return view('dashboard.user-profile.view');
    }
}