<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePodcastRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
            'cover_image' => 'nullable|string|max:255',
            'language' => 'sometimes|string|max:10|in:fr,en,ar',
            'is_published' => 'sometimes|boolean'
        ];
    }

    public function messages()
    {
        return [
            'category_id.exists' => 'The selected category does not exist.',
            'language.in' => 'Language must be fr, en, or ar.'
        ];
    }
}
