<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class CreateLegacyRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::where('id', Auth::id())
            ->where('tier', '>', 2);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:1|max:40',
            'caption' => 'min:1|max:255',
            'image' => 'mimes:jpeg,jpg,png|max:10000'
        ];
    }
}
