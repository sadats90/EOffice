<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblematicPaper extends Model
{
    public function letterIssue(){
        return $this->belongsTo(LetterIssue::class);
    }
    public function documentType(){
        return $this->belongsTo(DocumentType::class);
    }
}
