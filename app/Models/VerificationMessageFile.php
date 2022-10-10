<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VerificationMessageFile extends Model
{
    public function verification_message()
    {
        return $this->belongsTo(User::class);
    }
}
