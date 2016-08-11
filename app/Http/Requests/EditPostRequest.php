<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class EditPostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $postId = $this->route('posts');

        return Post::where('id', $postId)
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
        return redirect()->back()->withInput()->withErrors('This is not your post to edit.');
    }
}
