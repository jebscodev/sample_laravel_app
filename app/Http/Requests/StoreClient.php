<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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
            'tranche_no' => 'required|integer',
            'unit_no' => 'required|string',
            'client_name' => 'required|string',
            'civil_status' => 'required|string',
            'address' => 'required|string',
            'tin' => 'required|string',
            'contact_no' => 'required|string',
            'email_address' => 'nullable|email:rfc,dns',
            // 'document_status' => 'required|boolean',
            'reservation_date' => 'required|string',
            'reservation_amount' => 'required|numeric',
            'equity' => 'required|numeric',
            'months_to_pay' => 'required|integer', 
            'payment_scheme' => 'required|string',
            'remarks' => 'required|string',
            'total_equity' => 'required|numeric',
            'total_eq_paid_less_reg_fee' => 'required|numeric',
            'monthly_equity' => 'required|numeric',
            'is_vatted' => 'required|boolean',
            'net_selling_price_wo_vat' => 'required|numeric',
            'net_selling_price_w_vat' => 'required|numeric',
            'remaining_balance' => 'required|numeric',
            'tcp' => 'required|numeric',
            'status' => 'required|boolean',
            'prospect_id' => 'required|integer',
            'project_id' => 'required|integer',
            'broker_id' => 'required|integer'
        ];
    }
}
