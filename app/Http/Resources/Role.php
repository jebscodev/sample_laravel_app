<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\RoleModuleTagging;
use App\Http\Resources\RoleModuleTagging as TaggingResource;

class Role extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'description' => $this->description,
        //     'status' => $this->status,
        //     'status_text' => $this->status ? 'Active' : 'Inactive',
        //     'access' => TaggingResource::collection(RoleModuleTagging::where('role_id', $this->id)->get())
        // ];
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'access' => TaggingResource::collection($this->whenLoaded('tagged_modules'))
        ];
    }
}
