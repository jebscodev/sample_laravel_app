<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required|integer',
            'unit_type_id' => 'required|integer',
            'unit_no' => 'required|string|unique:App\Unit',
            'level_no' => 'required|string',
            'lot_no' => 'required|string',
            'area' => 'required|numeric',
            'is_premium' => 'required|boolean',
            'price_per_sqm' => 'required|numeric',
            'excess_amount' => 'required|numeric',
            'excess_of_sqm_amount' => 'required|numeric',
            'premium_amount' => 'required|numeric',
            'base_price_amount' => 'required|numeric',
            'commission_incentive_amount' => 'required|numeric',
            'nsp_amount' => 'required|numeric',
            'vat_amount' => 'required|numeric',
            'reg_fee_amount' => 'required|numeric',
            'home_automation_amount' => 'required|numeric',
            'transfer_tax_amount' => 'required|numeric',
            'doc_stamp' => 'required|numeric',
            'misc_amount' => 'required|numeric',
            'total_other_charges' => 'required|numeric',
            'reservation_fee' => 'required|numeric',
            'tcp' => 'required|numeric',
            'status' => 'required|boolean',
            'sale_status' => 'required|boolean'
        ];
    }
}
