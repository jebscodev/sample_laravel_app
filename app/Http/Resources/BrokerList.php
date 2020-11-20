<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrokerList extends JsonResource
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
            'name' => $this->first_name.' '.$this->last_name,
            'address' => $this->address,
            'email_address' =>  $this->email_address,
            'contact_no' =>  $this->contact_no,
            'status_text' => $this->status ? 'Active' : 'Inactive'
        ];
    }
}
