<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Broker extends JsonResource
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
            'brokerage_firm' =>  $this->brokerage_firm,
            'email_address' =>  $this->email_address,
            'contact_no' =>  $this->contact_no,
            'tin_no' => $this->tin_no,
            'payment_schedule' =>  $this->payment_schedule,
            'status' => $this->status,
            'status_text' => $this->status ? 'Active' : 'Inactive'
        ];
    }
}
