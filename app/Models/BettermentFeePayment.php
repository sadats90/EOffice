<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BettermentFeePayment extends Model
{
    public function letter_issue(){
       return $this->belongsTo(LetterIssue::class);
    }
}
