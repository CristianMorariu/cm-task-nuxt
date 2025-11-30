<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray(Request $request): array
    {
        return [
            'id'          => (int) $this->id,
            'projectId'   => (int) $this->project_id,
            'userId'      => $this->user_id ? (int) $this->user_id : null,
            'name'        => $this->name,
            'description' => $this->description,
            'status'      => $this->status,   // 'todo' | 'doing' | 'done'
            'priority'    => $this->priority, // 'low' | 'medium' | 'high'
            'dueDate'     => $this->due_date?->toDateString(),
            'completedAt' => $this->completed_at?->toISOString(),
            'position'    => $this->position,

            // un pic de context
            'project'     => new ProjectResource($this->whenLoaded('project')),
            'assignee'    => new UserResource($this->whenLoaded('assignee')),
        ];
    }
}
