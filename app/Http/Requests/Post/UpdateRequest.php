<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // dont' forget to set this as true
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // make all of the fields required, set featured image to accept only images
        return [
            'title' => 'required|string|min:3|max:250',
            'desc' => 'required|string|min:3|max:6000',
            'location' => 'required|string|min:3|max:250',
            'tags' => 'required|string|min:1|max:250',
            'featured_image' => 'nullable|image|max:2024|mimes:jpg,jpeg,png',
        ];
    }
}
