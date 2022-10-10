<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ForwardPermission extends Model
{
    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
