<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomSchedule extends Model
{
    protected $table = 'room_schedules';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function exceptions(): HasMany
    {
        return $this->hasMany(
            RoomScheduleException::class,
            'room_schedule_id'
        );
    }
}
