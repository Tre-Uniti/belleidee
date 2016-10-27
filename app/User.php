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
    protected $fillable = ['handle', 'email', 'password','frequency', 'location', 'last_tag', 'theme'];

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

    public function drafts()
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

    public function supports()
    {
        return $this->hasMany('App\Support');
    }

    public function elevation()
    {
        return $this->hasMany('App\Elevate');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function intolerances()
    {
        return $this->hasMany('App\Intolerance');
    }

    public function moderations()
    {
        return $this->hasMany('App\Moderation');
    }

    public function adjudications()
    {
        return $this->hasMany('App\Adjudication');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function beaconRequests()
    {
        return $this->hasMany('App\BeaconRequest');
    }

    public function sponsorRequests()
    {
        return $this->hasMany('App\SponsorRequest');
    }

    public function sponsorship()
    {
        return $this->hasOne('App\Sponsorship');
    }

    public function legacy()
    {
        return $this->hasOne('App\Legacy');
    }


    /*
     * Get the bookmarks associated with the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookmarks()
    {
        return $this->belongsToMany('App\Bookmark')->withTimestamps();
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
        //Generate API token for user
        $api_token = str_random(60);
        while(User::where('api_token', '=', $api_token)->exists())
        {
            $api_token = str_random(60);
        }
        $this->verified = true;
        $this->emailToken = null;
        $this->location = 3;
        $this->frequency = 3;
        $this->theme = 1;
        $this->api_token = $api_token;
        $this->save();
    }
}
