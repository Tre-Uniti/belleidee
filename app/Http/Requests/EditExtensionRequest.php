<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Extension;
use Illuminate\Support\Facades\Auth;

class EditExtensionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $extensionId = $this->route('extensions');

        return Extension::where('id', $extensionId)
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
            'body'  => 'required|min:1|max:3500',
            'belief'=> 'required',
            'beacon_tag' => 'required'
        ];
    }
    // override to redirect back
    public function forbiddenResponse()
    {
        return redirect()->back()->withInput()->withErrors('This is not your extension and you are not a Mod or Admin.');
    }
}
