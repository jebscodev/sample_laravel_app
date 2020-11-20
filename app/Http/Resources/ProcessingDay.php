<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Project as ProjectResource;

class ProcessingDay extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,      
            'name' => $this->name,
            'status' => $this->status,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'no_of_days' => $this->whenPivotLoaded('project_processing_day', function () {
                return $this->pivot->no_of_days;
            }),
            'projects' => ProjectResource::collection($this->whenLoaded('projects'))
        ];
    }
}
