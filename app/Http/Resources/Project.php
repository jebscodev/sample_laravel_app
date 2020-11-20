<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Unit;
use App\Http\Resources\Unit as UnitResource;
use App\Http\Resources\UnitType as UnitTypeResource;
use App\Http\Resources\ProcessingDay as ProcessingDayResource;
use App\Http\Resources\OtherCharge as OtherChargeResource;

class Project extends JsonResource
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
            'name' => $this->name,
            'location' => $this->location,
            'area' => $this->area,
            'price_variation' => $this->price_variation,
            'base_price' => $this->base_price,
            'standard_floor_area' => $this->standard_floor_area,
            'excess_of_sqm' => $this->excess_of_sqm,
            'price_per_sqm' => $this->price_per_sqm,
            'premium' => $this->premium,
            'commission' => $this->commission,
            'nsp' => $this->nsp,
            'vat' => $this->vat,
            'reg_fee' => $this->reg_fee,
            'transfer_tax' => $this->transfer_tax,
            'doc_stamps' => $this->doc_stamps,
            'required_dp' => $this->required_dp,
            'misc_home_auto' => $this->misc_home_auto,
            'status' => $this->status,
            'status_text' => $this->status ? 'Active' : 'Inactive',
            'units' => $this->whenLoaded('unsold_units'),
            'unit_types' => $this->whenLoaded('unit_types', function () {
                $data = [];
                if (!empty($this->unit_types)) {
                    foreach ($this->unit_types as $unit_type) {
                        $data[] = [
                            'id' => $unit_type->id,
                            'name' => $unit_type->name,
                            'amount' => $unit_type->pivot->amount,
                            'home_automation' => $unit_type->pivot->home_automation
                        ];
                    }
                }
                return $data;
            }),
            'processing_days' => $this->whenLoaded('processing_days', function () {
                $data = [];
                if (!empty($this->processing_days)) {
                    foreach ($this->processing_days as $processing_day) {
                        $data[] = [
                            'id' => $processing_day->id,
                            'name' => $processing_day->name,
                            'no_of_days' => $processing_day->pivot->no_of_days
                        ];
                    }
                }
                return $data;
            }),
            'other_charges' => $this->whenLoaded('other_charges', function () {
                $data = [];
                if (!empty($this->other_charges)) {
                    foreach ($this->other_charges as $other_charge) {
                        $data[] = [
                            'id' => $other_charge->id,
                            'name' => $other_charge->name,
                            'percentage' => $other_charge->pivot->percentage
                        ];
                    }
                }
                return $data;
            })
        ];
    }
}
