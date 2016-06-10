<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class CreatePostRequest extends Request
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
            'title' => 'required|min:1|max:40',
            'body'  => 'min:5|max:3500',
            'belief'=> 'required',
            'source' => 'required',
            'caption' => 'max:250',
            'image' => 'mimes:jpeg,jpg,png|max:10000'
        ];
    }
}
