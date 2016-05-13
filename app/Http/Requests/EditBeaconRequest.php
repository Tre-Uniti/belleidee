<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class EditBeaconRequest extends Request
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
            'name' => 'required|min:5|max:50',
            'address' => 'required|min: 5',
            'country' => 'required|min: 2',
            'city' => 'required|min: 2',
            'beacon_tag'  => 'required|min:7|max:12|unique:beacons,beacon_tag,' . $this->get('id'),
            'belief' => 'required',
            'website' => 'min:10|max:275',
            'phone' => 'required|min: 10|max:18',
            'email' => 'required|email|max:255|unique:beacons,email,' . $this->get('id'),
            'guide' => 'required',
            'lat' => 'min:3',
            'long' => 'min: 3',
            'image' => 'mimes:jpeg,jpg,png|max:8000',
            'zip' => 'min:5|max:10',
        ];
    }
}
