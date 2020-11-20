<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class EquityBreakdown extends JsonResource
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
            'equity_no' => $this->equity_no,
            'due_date' => Carbon::parse($this->due_date)->toDateString(),
            'monthly_equity' => $this->monthly_equity,
            'penalty' => $this->penalty,
            'payment_status' => $this->payment_status,
            'equity_payment' => $this->whenLoaded('equity_payment')
        ];
    }
}
