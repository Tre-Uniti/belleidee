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
            'title' => 'required|min:5|max:40',
            'body'  => 'required|min:5|max:3500',
            'belief'=> 'required',
            'category' => 'required'
        ];
    }
    // override to redirect back
    public function forbiddenResponse()
    {
        return redirect()->back()->withInput()->withErrors('This is not your extension and you are not a Mod or Admin.');
    }
}
