<?php

namespace App;

use App\Models\District;
use App\Models\Upazila;
use Illuminate\Database\Eloquent\Model;

class MouzaArea extends Model
{
    public function upazila(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }
}
