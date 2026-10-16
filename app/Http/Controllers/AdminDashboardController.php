<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Major;
use App\Models\Room;
use App\Models\User;

// use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
        {
            return view('admin.index', [
                'totalUsers' => User::count(),
                'totalMajors' => Major::count(),
                'totalBuildings' => Building::count(),
                'totalRooms' => Room::count(),
            ]);
        }
}
