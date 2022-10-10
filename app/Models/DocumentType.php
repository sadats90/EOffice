<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    public function  applicationDocuments(){
        return $this->hasMany(ApplicationDocument::class);
    }
}
