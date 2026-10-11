<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $table = 'majors';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }
}
