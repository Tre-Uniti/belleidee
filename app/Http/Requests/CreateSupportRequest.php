<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSupportRequest extends Request
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
            'subject' => 'required|min:2|max:40',
            'request' => 'required|min:5|max:300',
            'type' => 'required',
        ];
    }
}
