<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class EquityPayment extends JsonResource
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
            'date_paid' => Carbon::parse($this->date_paid)->toDateString(),
            'total_amount_payable' => $this->total_amount_payable,
            'less_advance_payment' => $this->less_advance_payment,
            'remaining_payable' => $this->remaining_payable,
            'amount_paid' => $this->amount_paid,
            'amount_change' => $this->amount_change,
            'is_added_to_advance' => $this->is_added_to_advance,
            'receipt_no_equity' => $this->receipt_no_equity,
            'receipt_no_penalty' => $this->receipt_no_penalty,
            'status' => $this->status
        ];
    }
}
