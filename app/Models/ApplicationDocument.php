<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
