<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingMajor extends Model
{
    protected $table = 'building_major';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
