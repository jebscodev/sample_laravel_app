<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Equity extends JsonResource
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
            'total_equity' => $this->total_equity,
            'total_equity_paid' =>  $this->total_equity_paid,
            'total_penalties' =>  $this->total_penalties,
            'total_penalty_paid' =>  $this->total_penalty_paid,
            'remaining_balance' =>  $this->remaining_balance,
            'equity_paid_pctg' => $this->equity_paid_pctg,
            'letter_of_notice_status' => $this->letter_of_notice_status,
            'client' => $this->whenLoaded('client', function () {
                return [
                    'id' => $this->client->id,
                    'client_name' => $this->client->client_name,
                    'documents' => [
                        [
                            'id' => $this->client->documents[0]->id,
                            'requirements_status' => $this->client->documents[0]->requirements_status
                        ]
                    ],
                    'unit' => [
                        'id' => $this->client->unit->id,
                        'unit_no' => $this->client->unit->unit_no
                    ],
                    'project' => [
                        'id' => $this->client->project->id,
                        'name' => $this->client->project->name
                    ],
                    'cts_file' => [
                        'id' => $this->client->cts_file->id ?? null,
                        'cts_status' => $this->client->cts_file->cts_status ?? null
                    ]
                ];
            })
        ];
    }
}
