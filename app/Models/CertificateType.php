<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateType extends Model
{
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'certificate_type_id');
    }
}
