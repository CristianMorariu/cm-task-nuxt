<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'        => (int)$this->id,
            'username'  => $this->username,
            'email'     => $this->email,
            'fullName'  => $this->full_name,
            'role'      => $this->role->value,   // 'admin' | 'manager' | 'user'
            'abilities' => $this->abilities(),
            'avatar'    => $this->avatar, // path brut
             'avatar_url' => $this->avatar
                ? Storage::disk('public')->url($this->avatar)
                : null,
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}
