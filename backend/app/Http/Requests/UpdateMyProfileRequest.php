<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool { return true; }

    protected function prepareForValidation(): void
    {
        // mapăm camelCase -> snake_case
        if ($this->hasAny(['fullName','full_name'])) {
            $full = $this->input('fullName', $this->input('full_name'));
            $this->merge(['full_name' => blank($full) ? null : $full]);
        }
    }

    public function rules(): array
    {
        $id = $this->user()->id;

        return [
            'username'   => ['sometimes','string','max:50',"unique:users,username,{$id}"],
            'email'      => ['sometimes','email','max:255',"unique:users,email,{$id}"],
            'full_name'  => ['sometimes','nullable','string','max:255'],
            'avatar'     => ['sometimes','nullable','image','max:2048'], // ~2MB
            // parola NU se schimbă aici
        ];
    }
}
