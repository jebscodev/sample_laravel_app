<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\Document as DocumentResource;

class ClientList extends JsonResource
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
            'tranche_no' => $this->tranche_no,
            'client_name' => $this->client_name,
            'reservation_date' => Carbon::parse($this->reservation_date)->toDateString(),
            'remaining_balance' => $this->remaining_balance,
            'tcp' => $this->tcp,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'documents' => $this->whenLoaded('documents', function () {
                foreach ($this->documents as $doc) {
                    switch($doc->requirements_status){
                        case '0':
                            $requirement_status_text = 'Incomplete';
                            break;
                        case '1':
                            $requirement_status_text = 'Complete';
                            break;
                        case '2':
                            $requirement_status_text = 'Override';
                            break;
                        default:
                            $requirement_status_text = 'Incomplete';
                            break;
                    }

                    if ($doc->date_completed !== null) {
                        $doc->date_completed = Carbon::parse($doc->date_completed)->toDateString();
                    }

                    $data[] = [
                        'id' => $doc->id,
                        'requirements_status_text' => $requirement_status_text,
                        'date_completed' => $doc->date_completed,
                    ];
                }
                return $data;
            })
        ];
    }
}
