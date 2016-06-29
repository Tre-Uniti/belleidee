<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legacy extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'legacies';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function belief()
    {
        return $this->belongsTo('App\Belief');
    }
}
