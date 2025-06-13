<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function dashBoard(){
        return view("admin.dashboardManagement.dashBoard");
    }
}
