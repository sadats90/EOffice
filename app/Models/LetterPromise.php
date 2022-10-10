<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterPromise extends Model
{
    public function letter_issue()
    {
        return $this->belongsTo(LetterIssue::class);
    }
}
