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
            'user_id'       => ['sometimes','exists:users,id'],
            'name'          => ['sometimes','string','max:255'],
            'description'   => ['sometimes','nullable','string'],
            'supervisor_id' => ['sometimes','nullable','exists:users,id'],
            'deadline'      => ['sometimes','nullable','date'],
            'status'        => ['sometimes','in:active,archived'],
        ];
    }
}
