<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Project as ProjectResource;

class UnitType extends JsonResource
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
            'description' => $this->description,
            'status' => $this->status,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'project' => $this->whenLoaded('projects', function () {
                foreach ($this->projects as $project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'home_automation' => $project->pivot->home_automation,
                        'amount' => $project->pivot->amount
                    ];
                }
            })
        ];
    }
}
