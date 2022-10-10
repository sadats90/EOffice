<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GovernmentCertificate extends Model
{
    public function laws()
    {
        return $this->hasMany(GovernmentCertificateLaw::class);
    }
}
