<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotOwnProjectInfo extends Model
{
    function not_own_project_extra_infos(): HasMany
    {
        return $this->hasMany(NotOwnProjectExtraInfo::class);
    }

}
