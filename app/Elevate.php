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
        'extension_id',
        'source_user',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    public function extension()
    {
        return $this->belongsTo('App\Extension');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }
}
