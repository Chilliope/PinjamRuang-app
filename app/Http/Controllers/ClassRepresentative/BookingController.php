<?php

namespace App\Http\Controllers\ClassRepresentative;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('room.building')
            ->latest()
            ->paginate(10);

        return view(
            'class_representative.bookings.index',
            compact('bookings')
        );
    }

    public function create()
    {
        $rooms = Room::with('building')
            ->orderBy('room_name')
            ->get();

        return view(
            'class_representative.bookings.create',
            compact('rooms')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => [
                'required',
                'integer',
                'exists:rooms,id',
            ],
            'purpose' => [
                'required',
                'string',
                'max:2000',
            ],
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
        ]);

        Booking::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('class-representative.bookings.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function show(Booking $booking)
    {
        abort_unless(
            $booking->user_id === Auth::id(),
            403
        );

        $booking->load('room.building', 'reviewer');

        return view(
            'class_representative.bookings.show',
            compact('booking')
        );
    }
}
