<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Belief extends Model
{
    protected $fillable = [
        'name',
        'description',
        'photo_path',
    ];

    public function legacy()
    {
        return $this->hasOne('App\Legacy');
    }
}
