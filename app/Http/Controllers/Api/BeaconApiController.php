<?php

namespace App\Http\Controllers\Api;

use App\Beacon;
use App\Extension;
use App\Http\Controllers\Controller;
use App\Post;
use App\Transformers\BeaconTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class BeaconApiController extends Controller
{
    /*
     * Show the details of a specific beacon
     * @param $id
     */
    public function show($id)
    {
        $user = Auth::guard('api')->user();
        try
        {
            $beacon = Beacon::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {

            return $this->response->errorNotFound('Beacon not found');
        }

        if($user->id == $beacon->manager)
        {
            return $beacon;
        }
        else
        {
            return ['Sorry, you are not authorized to access this beacon'];
        }

        //return $this->response->item($beacon, new BeaconTransformer());
    }

    /*
     * List the latest guide posts for a given beacon
     * @param $id
     */
    public function guidePosts($id)
    {
        $user = Auth::guard('api')->user();
        try
        {
            $beacon = Beacon::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {

            return ['Sorry, Beacon not found'];
        }

        if($user->id == $beacon->manager)
        {
            $guidePosts = Post::where('beacon_tag', '=', $beacon->beacon_tag)->where('user_id', '=', $beacon->guide)->take(10)->get();
            return ['beacon' => $beacon, 'guidePosts' => $guidePosts];
        }
        else
        {
            return ['Sorry, you are not authorized to access this beacon'];
        }
    }

    /*
     * List the latest posts for a given beacon
     * @param $id
     */
    public function posts($id)
    {
        $user = Auth::guard('api')->user();
        try
        {
            $beacon = Beacon::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {

            return ['Sorry, Beacon not found'];
        }

        if($user->id == $beacon->manager)
        {
            $posts = Post::where('beacon_tag', '=', $beacon->beacon_tag)->take(10)->get();
            return ['beacon' => $beacon, 'posts' => $posts];
        }
        else
        {
            return ['Sorry, you are not authorized to access this beacon'];
        }
    }

    /*
     * List the latest extensions for a given beacon
     * @param $id
     */
    public function extensions($id)
    {
        $user = Auth::guard('api')->user();
        try
        {
            $beacon = Beacon::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {

            return ['Sorry, Beacon not found'];
        }

        if($user->id == $beacon->manager)
        {
            $extensions = Extension::where('beacon_tag', '=', $beacon->beacon_tag)->take(10)->get();
            return ['beacon' => $beacon, 'extensions' => $extensions];
        }
        else
        {
            return ['Sorry, you are not authorized to access this beacon'];
        }
    }


}
