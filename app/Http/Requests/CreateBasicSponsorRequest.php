<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CreateBasicSponsorRequest extends Request
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
            'name' => 'required|min:2|max:50',
            'address' => 'required|min: 5',
            'country' => 'required|min: 2',
            'city' => 'required|min: 2',
            'zip' => 'min:3|max:10',
            'website' => 'min:10|max:275',
            'phone' => 'required|min: 9|max:18',
            'email' => 'required|email|max:255|unique:sponsor_requests|unique:sponsors',
        ];
    }
}
