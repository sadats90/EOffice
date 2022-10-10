<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterFeedback extends Model
{
    public function letter_issue(){
        $this->belongsTo(LetterIssue::class);
    }

}
