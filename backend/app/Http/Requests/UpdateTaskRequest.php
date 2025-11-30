<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'description' => ['sometimes','nullable','string'],
            'status'      => ['sometimes','in:todo,doing,done'],
            'priority'    => ['sometimes','in:low,medium,high'],
            'due_date'    => ['sometimes','nullable','date'],
            'position'    => ['sometimes','integer','min:0'],
            'user_id'     => ['sometimes','nullable','exists:users,id'],
        ];
    }
}
