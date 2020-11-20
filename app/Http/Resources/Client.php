<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Unit;
use App\Http\Resources\Unit as UnitResource;
use App\Prospect;
use App\Http\Resources\Prospect as ProspectResource;
use App\Broker;
use App\Http\Resources\Broker as BrokerResource;
use App\Document;
use App\Http\Resources\Document as DocumentResource;
use Carbon\Carbon;

class Client extends JsonResource
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
            'unit_id' => $this->unit_id,
            'tranche_no' => $this->tranche_no,
            'client_name' => $this->client_name,
            'civil_status' => $this->civil_status,
            'civil_status_text' => $this->civil_status === '1' ? 'Married' : 'Single',
            'address' => $this->address,
            'tin' => $this->tin,
            'contact_no' => $this->contact_no,
            'email_address' => $this->email_address,
            'documents' => DocumentResource::collection($this->whenLoaded('documents')),
            'reservation_date' => Carbon::parse($this->reservation_date)->toDateString(),
            'reservation_amount' => $this->reservation_amount,
            'equity' => $this->equity,
            'months_to_pay' => $this->months_to_pay,
            'payment_scheme' => $this->payment_scheme,
            'remarks' => $this->remarks,
            'total_equity' => $this->total_equity,
            'total_eq_paid_less_reg_fee' => $this->total_eq_paid_less_reg_fee,
            'monthly_equity' => $this->monthly_equity,
            'is_vatted' => $this->is_vatted,
            'net_selling_price_wo_vat' => $this->net_selling_price_wo_vat,
            'net_selling_price_w_vat' => $this->net_selling_price_w_vat,
            'remaining_balance' => $this->remaining_balance,
            'tcp' => $this->tcp,
            'status' => $this->status,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'project' => $this->whenLoaded('project'),
            'unit' => $this->whenLoaded('unit'),
            'prospect' => $this->whenLoaded('prospect'),
            'broker' => $this->whenLoaded('broker')
        ];
    }
}
