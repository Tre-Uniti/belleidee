<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateInviteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'beta_Token' => 'required|min:7|unique:invites',
            'to_email' => 'required|email|unique:invites',
        ];
    }
}
