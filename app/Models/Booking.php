<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $guarded = [
        'id',
        'create_at',
        'updated_at'
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    // Pengguna yang mengajukan peminjaman
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Ruangan yang dipinjam
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // Staff yang memproses pengajuan
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class,'reviewed_by');
    }
}
