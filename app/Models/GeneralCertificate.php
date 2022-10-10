<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralCertificate extends Model
{
    public function applicants()
    {
        return $this->hasMany(GeneralCertificateApplicant::class);
    }
}
