<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class CreateBeliefRequest extends Request
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
            'name' => 'required|min:1|max:200',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png|max:10000'
        ];
    }
}
