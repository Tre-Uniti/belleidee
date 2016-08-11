<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CreateDraftRequest extends Request
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
            'title' => 'required|min:1|max:40|unique:drafts',
            'body'  => 'min:5|max:5000',
            'belief'=> 'required',
            'source' => 'required',
            'caption' => 'max:250',
            'image' => 'mimes:jpeg,jpg,png|max:10000'
        ];
    }
}
