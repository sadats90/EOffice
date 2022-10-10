<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function workingPermissions()
    {
        return $this->hasMany(WorkingPermission::class);
    }
}
