<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackPaper extends Model
{
    public function letter_issue(){
      return $this->belongsTo(LetterIssue::class);
    }

    public function document_type(){
        return $this->belongsTo(DocumentType::class);
    }
}
