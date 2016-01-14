<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class CreateSponsorRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::where('id', Auth::id())
            ->where('tier', '>', 3);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50|unique:sponsors',
            'website'  => 'required|min:10|max:275|unique:sponsors',
            'phone' => 'required|min: 10|max:15',
            'country' => 'required|max:50',
            'city'  => 'required|max:75',
            'budget' => 'required|min:1|max:15',
            'email' => 'required|email|max:255|unique:sponsors'
        ];
    }
}
