<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateAttachment extends Model
{
    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
}
