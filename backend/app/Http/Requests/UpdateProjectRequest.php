<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'name'        => ['sometimes','required','string','max:255'],
            'description' => ['sometimes','nullable','string','max:2000'],
            'color'       => ['sometimes','nullable','regex:/^#([0-9a-fA-F]{6})$/'],
            'status'      => ['sometimes','in:active,archived'],
        ];
    }
}
