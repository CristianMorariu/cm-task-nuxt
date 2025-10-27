<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        $user = $this->route('user'); // model binding
        return $this->user()->can('update', $user);
    }
    protected function prepareForValidation(): void
    {
        if ($this->hasAny(['fullName','full_name'])) {
            $full = $this->input('fullName', $this->input('full_name'));
            $this->merge(['full_name' => blank($full) ? null : $full]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $userId = $this->route('user')->id;
        return [
            'username'   => ['sometimes','string','max:50',"unique:users,username,{$userId}"],
            'email'      => ['sometimes','email','max:255',"unique:users,email,{$userId}"],
            'full_name'  => ['sometimes','nullable','string','max:255'],
            'role'       => ['sometimes','in:admin,manager,user'], // manager & user nu vor trece de policy oricum
            'password'   => ['sometimes','nullable','string','min:8'],
            'avatar'     => ['sometimes','nullable','image','max:2048'],
        ];
    }
}
