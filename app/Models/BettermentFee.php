<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BettermentFee extends Model
{
    public function letter_issue()
    {
        return $this->belongsTo(LetterIssue::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
