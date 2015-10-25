<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'user_id',
        'to_email',
        'beta_token',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
