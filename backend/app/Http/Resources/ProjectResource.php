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
            'id'           => (int) $this->id,
            'userId'       => (int) $this->user_id,
            'name'         => $this->name,
            'description'  => $this->description,
            'status'       => $this->status,

            'deadline'     => $this->deadline?->toISOString(),
            'deadlineFormatted' => $this->deadline
            ? $this->deadline->timezone('Europe/Bucharest')->format('d.m.Y')
            : null,
            'createdAt'    => $this->created_at?->toISOString(),
            'updatedAt'    => $this->updated_at?->toISOString(),

            'supervisor'   => $this->whenLoaded('supervisor', fn () => new UserTinyResource($this->supervisor)),

            // ex. cu withCount('tasks')
            'tasksCount'   => $this->when(isset($this->tasks_count), (int) $this->tasks_count),

        ];
    }
}
