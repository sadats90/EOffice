<?php

namespace App\Models;

use App\MouzaArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Upazila extends Model
{
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function mouza_areas(): HasMany
    {
        return $this->hasMany(MouzaArea::class);
    }
}
