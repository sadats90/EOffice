<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationPersonalInfo extends Model
{
    public function applicants(): HasMany
    {
        return $this->hasMany(ApplicationApplicant::class, 'application_personal_info_id');
    }
}
