<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'assigned_to' => new UserResource($this->whenLoaded('assignedUser')),
            'created_by' => new UserResource($this->whenLoaded('creator')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
