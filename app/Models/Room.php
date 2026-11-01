<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    protected $table = 'rooms';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function schedules()
    {
        return $this->hasMany(RoomSchedule::class);
    }

    public function replacementExceptions()
    {
        return $this->hasMany(
            RoomScheduleException::class,
            'replacement_room_id'
        );
    }
}
