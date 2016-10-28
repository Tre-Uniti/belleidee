<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Moderation;
use Illuminate\Support\Facades\Auth;

class EditModerationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if($user->tier > 0)
        {
            return true;
        }
        else
        $moderationId = $this->route('moderations');
        return Moderation::where('id', $moderationId)
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
            'mod_ruling' => 'required|min:5|max:300',
            'admin_ruling' => 'min:5|max:300',
        ];
    }
}
