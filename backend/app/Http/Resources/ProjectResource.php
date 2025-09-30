<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'userId'      => $this->user_id,
            'name'        => $this->name,
            'description' => $this->description,
            'color'       => $this->color,
            'status'      => $this->status,
            'createdAt'   => $this->created_at?->toISOString(),
            'updatedAt'   => $this->updated_at?->toISOString(),
            // ex. dacă folosești withCount('tasks')
            'tasksCount'  => $this->when(isset($this->tasks_count), $this->tasks_count),
        ];
    }
}
