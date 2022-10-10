<?php

namespace App;

use App\Models\Designation;
use App\Models\ForwardPermission;
use App\Models\UserDetails;
use App\Models\WorkHandover;
use App\Models\WorkingPermission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function userDetails()
    {
        return $this->hasOne(UserDetails::class);
    }

    public function workingPermissions()
    {
        return $this->hasMany(WorkingPermission::class);
    }
    public function forwardPermission()
    {
        return $this->hasMany(ForwardPermission::class);
    }

    public function workHandovers()
    {
        return $this->hasMany(WorkHandover::class, 'user_id');
    }

    public function fromWorkHandovers()
    {
        return $this->hasMany(WorkHandover::class, 'from_user_id');
    }

}
