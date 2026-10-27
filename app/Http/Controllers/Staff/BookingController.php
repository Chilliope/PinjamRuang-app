<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Daftar pengajuan dari gedung yang ditugaskan
     * kepada Staff yang sedang login.
     */
    public function index(): View
    {
        $bookings = Booking::query()
            ->whereHas('room.building.staff', function ($query) {
                $query->whereKey(Auth::id());
            })
            ->with(['user', 'room.building'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('booking_date')
            ->orderBy('start_time')
            ->paginate(10);

        return view('staff.bookings.index', compact('bookings'));
    }

    /**
     * Detail pengajuan.
     */
    public function show(Booking $booking): View
    {
        $this->ensureCanManage($booking);

        $booking->load([
            'user',
            'room.building',
            'reviewer',
        ]);

        return view('staff.bookings.show', compact('booking'));
    }

    /**
     * Menyetujui pengajuan dan mencegah bentrok jadwal.
     */
    public function approve(Booking $booking): RedirectResponse
    {
        DB::transaction(function () use ($booking) {
            $booking = Booking::query()
                ->whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->ensureCanManage($booking);

            if ($booking->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Pengajuan ini sudah diproses sebelumnya.',
                ]);
            }

            // Kunci baris ruangan agar proses persetujuan
            // untuk ruangan yang sama berjalan bergantian.
            Room::query()
                ->whereKey($booking->room_id)
                ->lockForUpdate()
                ->firstOrFail();

            $hasConflict = Booking::query()
                ->where('room_id', $booking->room_id)
                ->whereDate(
                    'booking_date',
                    $booking->booking_date->toDateString()
                )
                ->where('status', 'approved')
                ->where('id', '!=', $booking->id)
                ->where('start_time', '<', $booking->end_time)
                ->where('end_time', '>', $booking->start_time)
                ->exists();

            if ($hasConflict) {
                throw ValidationException::withMessages([
                    'schedule' => 'Jadwal bentrok dengan peminjaman lain yang sudah disetujui.',
                ]);
            }

            $booking->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'rejection_reason' => null,
            ]);
        });

        return redirect()
            ->route('staff.bookings.show', $booking)
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    /**
     * Menolak pengajuan dengan alasan.
     */
    public function reject(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:2000'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 2000 karakter.',
        ]);

        DB::transaction(function () use ($booking, $validated) {
            $booking = Booking::query()
                ->whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->ensureCanManage($booking);

            if ($booking->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Pengajuan ini sudah diproses sebelumnya.',
                ]);
            }

            $booking->update([
                'status' => 'rejected',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'rejection_reason' => $validated['rejection_reason'],
            ]);
        });

        return redirect()
            ->route('staff.bookings.show', $booking)
            ->with('success', 'Pengajuan berhasil ditolak.');
    }

    /**
     * Pastikan Staff ditugaskan pada gedung ruangan tersebut.
     */

    private function ensureCanManage(Booking $booking): void
    {
        $buildingId = $booking->room()
            ->value('building_id');

        abort_unless(
            $buildingId !== null
                && Auth::user()
                ->buildings()
                ->where('buildings.id', $buildingId)
                ->exists(),
            403,
            'Kamu tidak memiliki akses untuk memproses pengajuan ini.'
        );
    }
}
