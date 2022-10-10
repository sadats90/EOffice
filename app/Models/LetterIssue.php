<?php

namespace App\Models;

use App\LetterLaw;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LetterIssue extends Model
{
    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class);
    }

    public function betterment_fee(): HasOne
    {
        return $this->hasOne(BettermentFee::class);
    }

    public function promise(): HasOne
    {
        return $this->hasOne(LetterPromise::class);
    }

    public function problematic_papers(): HasMany
    {
        return $this->hasMany(ProblematicPaper::class);
    }

    public function letter_laws(): HasMany
    {
        return $this->hasMany(LetterLaw::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    public function letter_feedBack(): HasOne
    {
       return $this->hasOne(LetterFeedback::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function onBehalfOf(): BelongsTo
    {
        return $this->belongsTo(User::class, 'on_behalf_of');
    }

    public function betterment_fee_payment(): HasOne
    {
        return $this->hasOne(BettermentFeePayment::class);
    }

    public function feedback_papers(): HasMany
    {
        return $this->hasMany(FeedbackPaper::class);
    }

    public function restoreApplication(): HasMany
    {
        return $this->hasMany(RestoreApplication::class, 'letter_issue_id');
    }
}
