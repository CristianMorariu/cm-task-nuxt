<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTinyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => (int) $this->id,
            'username'  => $this->username,
            'email' => $this->email,
            // adaugă aici câmpuri safe dacă îți mai trebuie (avatar, role etc.)
        ];
    }
}