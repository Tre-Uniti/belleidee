<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class CreateBeaconRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::where('id', Auth::id())
            ->where('tier', '>', 1);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:50',
            'address' => 'required|min: 5',
            'country' => 'required|min: 2',
            'city' => 'required|min: 2',
            'beacon_tag'  => 'required|min:7|max:12|unique:beacons',
            'belief' => 'required',
            'website' => 'min:10|max:275',
            'phone' => 'required|min: 10|max:18',
            'email' => 'email|max:255|unique:beacons',
            'guide' => 'required',
            'lat' => 'min:3',
            'long' => 'min: 3',
            'image' => 'mimes:jpeg,jpg,png|max:8000',
            'zip' => 'min:5|max:10',
        ];
    }
}
