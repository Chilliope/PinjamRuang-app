<?php

namespace App\Http\Controllers\ClassRepresentative;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomSchedule;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
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

        // Menentukan hari berdasarkan tanggal peminjaman
        $dayOfWeek = strtolower(
            Carbon::parse($validated['booking_date'])->englishDayOfWeek
        );

        // Memeriksa apakah waktu peminjaman bertabrakan
        // dengan jadwal rutin ruangan
        $scheduleConflict = RoomSchedule::where(
            'room_id',
            $validated['room_id']
        )
            ->where('day_of_week', $dayOfWeek)
            ->where('start_time', '<', $validated['end_time'])
            ->where('end_time', '>', $validated['start_time'])
            ->with('room')
            ->first();

        if ($scheduleConflict) {
            throw ValidationException::withMessages([
                'start_time' => [
                    'Ruangan tidak tersedia karena memiliki jadwal "'
                        . $scheduleConflict->schedule_name
                        . '" pada hari tersebut, pukul '
                        . Carbon::parse($scheduleConflict->start_time)->format('H:i')
                        . '–'
                        . Carbon::parse($scheduleConflict->end_time)->format('H:i')
                        . '. Silakan pilih waktu lain.',
                ],
            ]);
        }

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
