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
        $completedCount = $this->entries->where('is_completed', 1)->count();
        $totalDays = now()->daysInMonth;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'completion_percentage' => $totalDays > 0 ? round(($completedCount / $totalDays) * 100, 1) : 0,
            'entries' =>TaskEntriesResource::collection($this->whenLoaded('entries'))
        ];
        // return parent::toArray($request);
    }
}
