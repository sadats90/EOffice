<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotOwnProjectExtraInfo extends Model
{
    public function mouzaArea(): BelongsTo
    {
        return $this->belongsTo(MouzaArea::class);
    }
}
