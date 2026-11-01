<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    protected $table = 'classes';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function classRepresentatives(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'class_classrep',
            'class_id',
            'user_id'
        )->withTimestamps();
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(RoomSchedule::class, 'class_id');
    }
}
