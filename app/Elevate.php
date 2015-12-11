<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elevate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'elevation';

    protected $fillable = [
        'post_id',
        'extension_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
