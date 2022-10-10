<?php

namespace App\Models;

use App\NotOwnProjectInfo;
use App\OwnProjectInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApplicationLandInfo extends Model
{
    protected $fillable = [];

    public function land_use_future(): BelongsTo
    {
        return $this->belongsTo(LandUseFuture::class, 'land_future_use');
    }

    public function land_use_present(): BelongsTo
    {
        return $this->belongsTo(LandUsePresent::class, 'land_currently_use');
    }

    public function own_project_info(): HasOne
    {
        return $this->hasOne(OwnProjectInfo::class);
    }
    public function not_own_project_info(): HasOne
    {
        return $this->hasOne(NotOwnProjectInfo::class);
    }
}
