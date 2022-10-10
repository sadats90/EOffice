<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class WorkingPermission extends Model
{
    public function task(){
        return $this->belongsTo(Task::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
