<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;
    protected $table = 'buildings';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function majors(): BelongsToMany
    {
        return $this->belongsToMany(Major::class);
    }
}
