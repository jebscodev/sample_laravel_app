<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CtsFile extends JsonResource
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
            'date_printed' => $this->date_printed != null ? Carbon::parse($this->date_printed)->toDateString() : $this->date_printed,
            'date_signed' => $this->date_signed != null ? Carbon::parse($this->date_signed)->toDateString() : $this->date_signed,
            'date_notarized' => $this->date_notarized != null ? Carbon::parse($this->date_notarized)->toDateString() : $this->date_notarized,
            'cts_status' => $this->cts_status,
            'total_days' => $this->total_days,
            'kra' => $this->kra,
            'client' => $this->whenLoaded('client')
        ];
    }
}
