<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Module extends JsonResource
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
            'module_id' => $this->id,
            'name' => $this->name,
            'status' => $this->status ? 'Active' : 'Inactive',
            
            // access has to be static as it is only created on adding new roles
            'read' => 1,
            'write' => 0,
            'update' => 0
        ];
    }
}
