<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    public function letterIssues(){
        return $this->hasMany(LetterIssue::class);
    }
}
