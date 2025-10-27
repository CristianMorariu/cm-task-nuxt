<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function authorize(): bool { return $this->user()->can('create', User::class); }

   protected function prepareForValidation(): void
    {
        $full = $this->input('fullName', $this->input('full_name'));

        $this->merge([
            'full_name' => blank($full) ? null : $full, // goale -> null
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
     public function rules(): array {
        return [
            'username'   => ['required','string','max:50','unique:users,username'],
            'email'      => ['required','email','max:255','unique:users,email'],
            'full_name'  => ['nullable','string','max:255'],
            'role'       => ['required','in:admin,manager,user'],
            'password'   => ['required','string','min:8'],
            'avatar'     => ['nullable','image','max:2048'], // ~2MB
        ];
    }
}
