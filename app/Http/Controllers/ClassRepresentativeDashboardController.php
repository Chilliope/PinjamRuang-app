<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ClassRepresentativeDashboardController extends Controller
{
    public function index()
    {
        // Mengambil seluruh peminjaman milik pengguna yang sedang login
        $query = Booking::where('user_id', Auth::id());

        // Menghitung statistik peminjaman
        $totalBookings = (clone $query)->count();

        $pendingBookings = (clone $query)
            ->where('status', 'pending')
            ->count();

        $approvedBookings = (clone $query)
            ->where('status', 'approved')
            ->count();

        $rejectedBookings = (clone $query)
            ->where('status', 'rejected')
            ->count();

        // Mengambil 5 pengajuan peminjaman terbaru
        $recentBookings = (clone $query)
            ->with('room.building')
            ->latest()
            ->take(5)
            ->get();

        return view('class_representative.index', compact(
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'rejectedBookings',
            'recentBookings'
        ));
    }
}
