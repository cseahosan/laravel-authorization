<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id'
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

    /**
     * The methodes that should be check user's role.
     *
     * @method
     */

    public function isAdmin()
    {
        return $this->role_id == env('ADMIN_ROLE_ID', 1);
    }

    public function isStudent()
    {
        return $this->role_id == env('STUDENT_ROLE_ID', 2);
    }

    public function isAuthorize()
    {
        if(is_null($this->role_id)) {
            return false;
        }

        return true;
    }

    /**
     * Get the type of the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
