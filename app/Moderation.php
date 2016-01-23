<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moderation extends Model
{
    protected $fillable = [
        'mod_ruling',
        'admin_ruling',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
