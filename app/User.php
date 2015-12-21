<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['handle', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function extensions()
    {
        return $this->hasMany('App\Extension');
    }

    public function invites()
    {
        return $this->hasMany('App\Invite');
    }

    public function elevation()
    {
        return $this->hasMany('App\Elevate');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($user)
        {
            $user->emailToken = str_random(30);
        });
    }
    public function confirmEmail()
    {
        $this->verified = true;
        $this->emailToken = null;
        $this->save();
    }
}
