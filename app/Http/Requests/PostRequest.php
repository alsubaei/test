<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required:posts,title',
            'image' => 'required:posts,image',
            'content' => 'required:posts,content',
            
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Enter the post title',
            'image.required' => 'Enter the post image',
            'content.required' => 'Enter the content',
            ];
    }
}
