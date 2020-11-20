<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Role;
use App\Module;

class RoleModuleTagging extends JsonResource
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
        //     'role' => Role::find($this->role_id)->name,
        //     'module' => Module::find($this->module_id)->name,
        //     'read' => $this->read ? 'yes' : 'no',
        //     'write' => $this->write ? 'yes' : 'no',
        //     'update' => $this->update ? 'yes' : 'no',
        // ];

        return [
            'id' => $this->id,
            // 'role_id' => $this->role_id,
            // 'role' => Role::find($this->role_id)->name,
            'module_id' => $this->pivot->module_id,
            'name' => Module::find($this->pivot->module_id)->name,
            'read' => $this->pivot->read,
            'write' => $this->pivot->write,
            'update' => $this->pivot->update
        ];
    }
}
