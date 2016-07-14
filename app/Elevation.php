<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Elevation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'elevations';

    protected $fillable = [
        'post_id',
        'extension_id',
        'question_id',
        'legacy_post_id',
        'source_user',
        'beacon_tag',
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

    public function legacyPost()
    {
        return $this->belongsTo('App\LegacyPost', 'legacy_post_id');
    }
}
