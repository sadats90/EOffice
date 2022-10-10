<?php

namespace App;

use App\Models\LetterIssue;
use Illuminate\Database\Eloquent\Model;

class LetterLaw extends Model
{
    public function letterIssue(){
        return $this->belongsTo(LetterIssue::class);
    }
}
