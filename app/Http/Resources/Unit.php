<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\UnitType as UnitTypeResource;

class Unit extends JsonResource
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
            'unit_no' => $this->unit_no,
            'level_no' => $this->level_no,
            'lot_no' => $this->lot_no,
            'area' => $this->area,
            'is_premium' => $this->is_premium,
            'is_premium_text' => $this->is_premium ? 'Yes' : 'No',
            'price_per_sqm' => $this->price_per_sqm,
            'excess_amount' => $this->excess_amount,
            'excess_of_sqm_amount' => $this->excess_of_sqm_amount,
            'premium_amount' => $this->premium_amount,
            'base_price_amount' => $this->base_price_amount,
            'commission_incentive_amount' => $this->commission_incentive_amount,
            'nsp_amount' => $this->nsp_amount,
            'vat_amount' => $this->vat_amount,
            'reg_fee_amount' => $this->reg_fee_amount,
            'home_automation_amount' => $this->home_automation_amount,
            'transfer_tax_amount' => $this->transfer_tax_amount,
            'doc_stamp' => $this->doc_stamp,
            'misc_amount' => $this->misc_amount,
            'total_other_charges' => $this->total_other_charges,
            'reservation_fee' => $this->reservation_fee,
            'tcp' => $this->tcp,
            'status' => $this->status,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'sale_status' => $this->sale_status,
            'sale_status_text' => $this->sale_status ? 'Sold' : 'Unsold',
            'unit_type' => $this->whenLoaded('unit_type'),
            'project' => $this->whenLoaded('project')
        ];
    }
}
