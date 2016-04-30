<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CreateBasicBeaconRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50',
            'belief' => 'required',
            'address' => 'required|min: 5',
            'country' => 'required|min: 2',
            'city' => 'required|min: 2',
            'website' => 'min:10|max:275',
            'phone' => 'required|min: 10|max:18',
            'email' => 'email|max:255|unique:beacon_requests|unique:beacons',
        ];
    }
}
