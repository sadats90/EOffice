<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    public function upazilas(): HasMany
    {
        return $this->hasMany(Upazila::class);
    }

    public function branch(): HasMany
    {
        return $this->hasMany(Branch::class, 'district_id');
    }
}
