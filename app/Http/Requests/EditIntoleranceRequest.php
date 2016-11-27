<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Intolerance;
use Illuminate\Support\Facades\Auth;

class EditIntoleranceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $intoleranceId = $this->intolerance;

        return Intolerance::where('id', $intoleranceId)
            ->where('user_id', Auth::id())->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_ruling' => 'required|min:5|max:300',
        ];
    }
}
