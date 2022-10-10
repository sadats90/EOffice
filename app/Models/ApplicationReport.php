<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationReport extends Model
{
    public function devPlans()
    {
        return $this->hasMany(devPlan::class);
    }

    public function reportMaps()
    {
        return $this->hasMany(reportMap::class);
    }
}
