<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomScheduleException extends Model
{
    protected $table = 'room_schedule_exceptions';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'exception_date' => 'date',
            'replacement_date' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(
            RoomSchedule::class,
            'room_schedule_id'
        );
    }

    public function replacementRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'replacement_room_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
