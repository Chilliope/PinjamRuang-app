<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Ambil gedung yang ditugaskan kepada Staff.
        $buildingIds = $user->buildings()->pluck('buildings.id');

        // Hitung ruangan pada gedung yang dikelola.
        $roomsCount = Room::query()
            ->whereIn('building_id', $buildingIds)
            ->count();

        // Batasi pengajuan hanya pada gedung yang dikelola Staff.
        $bookingQuery = Booking::query()
            ->whereHas('room', function ($query) use ($buildingIds) {
                $query->whereIn('building_id', $buildingIds);
            });

        $pendingCount = (clone $bookingQuery)
            ->where('status', 'pending')
            ->count();

        $approvedCount = (clone $bookingQuery)
            ->where('status', 'approved')
            ->count();

        $rejectedCount = (clone $bookingQuery)
            ->where('status', 'rejected')
            ->count();

        // Ambil lima pengajuan terbaru untuk dashboard.
        $latestBookings = (clone $bookingQuery)
            ->with(['user', 'room.building'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('staff.index', compact(
            'roomsCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'latestBookings'
        ));
    }
}
