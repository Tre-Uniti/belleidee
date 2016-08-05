<?php

namespace App\Api\Controllers;

use App\Beacon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BeaconController extends BaseController
{
    public function show($id)
    {
        try
        {
            $beacon = Beacon::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {

            return $this->response->errorNotFound('Beacon not found');
        }

        return $this->response->item($beacon, new BeaconTransformer);
    }

}
