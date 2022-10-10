<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RestoreApplication extends Model
{
    public function CreatedBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function LetterIssue(){
        return $this->belongsTo(LetterIssue::class, 'letter_issue_id');
    }
}
