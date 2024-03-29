<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Extension extends Model
{
    protected $fillable = [
        'excerpt',
        'body',
        'belief',
        'beacon_tag',
        'source',
        'extension_path',
        'post_id',
        'source_user',
        'extenception',
        'answer_id',
        'question_id',
        'lat',
        'long',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function elevation()
    {
        return $this->hasMany('App\Elevate');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function legacyPost()
    {
        return $this->belongsTo('App\LegacyPost', 'legacy_post_id');
    }

    //Return title of extenception
    public function extenceptionTitle($id)
    {
        try
        {
            $extension = Extension::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            return 'Extension not found';
        }
        return $extension->title;
    }

    //Return # of extensions of extenception
    public function extenceptionExtension($id)
    {
        $extension = Extension::findOrFail($id);
        return $extension->extension;
    }

    //Return # of elevation of extenception
    public function extenceptionElevation($id)
    {
        $extension = Extension::findOrFail($id);
        return $extension->elevation;
    }

}
