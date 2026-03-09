<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DasboardAdminController extends Controller
{
     public function dashboard()
    {
        return view('admin.dashboard_admin');
    }
}
