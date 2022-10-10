<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VerificationMessage extends Model
{
    protected $fillable = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verification_message_files()
    {
        return $this->hasMany(VerificationMessageFile::class);
    }

    public function onBehalfOf()
    {
        return $this->belongsTo(User::class, 'on_behalf_of');
    }
}
