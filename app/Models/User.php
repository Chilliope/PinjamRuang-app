<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }

    public function buildings(): BelongsToMany
    {
        return $this->belongsToMany(
            Building::class,
            'building_staff',
            'staff_id',
            'building_id'
        )->withTimestamps();
    }


    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviewedBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'reviewed_by');
    }
}
