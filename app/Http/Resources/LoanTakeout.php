<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanTakeout extends JsonResource
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
            'financing_scheme' => $this->financing_scheme,
            'loan_status' => $this->loan_status,
            'loan_amount' => $this->loan_amount,
            'tcp' => $this->tcp,
            'variance' => $this->variance,
            'status' => $this->status,
            'total_days' => $this->total_days,
            'kra' => $this->kra,
            'client' => $this->whenLoaded('client', function () {
                return [
                    'id' => $this->client->id,
                    'client_name' => $this->client->client_name,
                    'unit_no' => $this->client->unit->unit_no
                ];
            })
        ];
    }
}
