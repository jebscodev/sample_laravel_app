<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnitList extends JsonResource
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
            'unit_no' => $this->unit_no,
            'area' => $this->area,
            'price_per_sqm' => $this->price_per_sqm,
            'tcp' => $this->tcp,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'sale_status_text' => $this->sale_status ? 'Sold' : 'Unsold',
            'unit_type' => $this->whenLoaded('unit_type'),
            'project' => $this->whenLoaded('project'),
            'client' => $this->whenLoaded('client')
        ];
    }
}
