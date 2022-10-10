<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RecievedApplication extends Model
{
    public function application(){
        return $this->belongsTo(Application::class);
    }

    public function from_user(){
        return $this->belongsTo(User::class, 'from_user_id');
    }
    public function to_user(){
        return $this->belongsTo(User::class, 'to_user_id');
    }

}
