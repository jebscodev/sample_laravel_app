<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class Ewt extends JsonResource
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
            'ewt_amount' => $this->ewt_amount,
            'rcp_date' => $this->rcp_date != null ? Carbon::parse($this->rcp_date)->toDateString() : $this->rcp_date,
            'est_release_date' => $this->est_release_date != null ? Carbon::parse($this->est_release_date)->toDateString() : $this->est_release_date,
            'actual_release_date' => $this->actual_release_date != null ? Carbon::parse($this->actual_release_date)->toDateString() : $this->actual_release_date,
            'date_paid' => $this->date_paid != null ? Carbon::parse($this->date_paid)->toDateString() : $this->date_paid,
            'total_days' => $this->total_days,
            'kra' => $this->kra,
            'client' => $this->whenLoaded('client')
        ];
    }
}
