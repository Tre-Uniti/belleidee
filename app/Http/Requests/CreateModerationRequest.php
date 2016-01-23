<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class CreateModerationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::where('id', Auth::id())
            ->where('tier', '>', 0);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mod_ruling' => 'required|min:5|max:300',
            'admin_ruling' => 'min:5|max:300',
        ];
    }
}
