<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Project as ProjectResource;

class OtherCharge extends JsonResource
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
            'percentage' => $this->whenPivotLoaded('project_other_charge', function () {
                return $this->pivot->percentage;
            }),
            'projects' => ProjectResource::collection($this->whenLoaded('projects'))
        ];
    }
}
