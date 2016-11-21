<?php

namespace App\Http\Requests;

use App\Draft;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class EditDraftRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //$draftId = route()->parameter('id');
        //dd($draftId);

        return Draft::where('id', $draftId)
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
            'title' => 'required|min:1|max:40',
            'body'  => 'min:5|max:5000',
            'belief'=> 'required',
            'source' => 'required',
            'caption' => 'max:250',
            'image' => 'mimes:jpeg,jpg,png|max:10000'
        ];
    }
    // override this to redirect back
    public function forbiddenResponse()
    {
        return redirect()->back()->withInput()->withErrors('This is not your draft to edit.');
    }
}
