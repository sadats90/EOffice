<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    public function personalInfo(): HasOne
    {
        return $this->hasOne(ApplicationPersonalInfo::class);
    }

    public function landInfo(): HasOne
    {
        return $this->hasOne(ApplicationLandInfo::class);
    }

    public function correction_request(): HasOne
    {
        return $this->hasOne(CorrectionRequest::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function report(): HasOne
    {
        return $this->hasOne(ApplicationReport::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function letter_issues(): HasMany
    {
        return $this->hasMany(LetterIssue::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function application_routes(): HasMany
    {
        return $this->hasMany(ApplicationRoute::class, 'application_id');
    }
    public function receive_application(): HasOne
    {
        return $this->hasOne(RecievedApplication::class);
    }
}
