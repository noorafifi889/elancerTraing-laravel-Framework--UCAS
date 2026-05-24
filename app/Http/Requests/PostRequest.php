<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
    'title' =>'required|string|min:3|max:255',
    'content' => 'required|string|max:99999',
    'cover' =>[
    'nullable',    
    'image' ,
    'mimes:png,jpg' ,
     'mimetypes:image/png,image/jpeg' ,
      'dimensions:min_width=600,min_height=400,max_width=2000,max_height=2000',
      'max:1024'
      ]
        ];
    }
    public function messages():array
{
return [
'required' =>':attribute is required',
'title.required' => ':attribute is mandatory',

];
}
#[Override]
public function attributes():array
{
    return [
        'title' => 'Post Title',
        'content' => 'Post Content',
        'cover' => 'Cover Image'
    ];
}

}


