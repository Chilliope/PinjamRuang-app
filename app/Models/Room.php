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
}
