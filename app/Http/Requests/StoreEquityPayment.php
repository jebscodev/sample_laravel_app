<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquityPayment extends FormRequest
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
            'date_paid' => 'required|string',
            'total_amount_payable' => 'required|numeric',
            'less_advance_payment' => 'required|numeric',
            'remaining_payable' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'amount_change' => 'required|numeric',
            'is_added_to_advance' => 'nullable|boolean',
            'receipt_no_equity' => 'nullable|string',
            'receipt_no_penalty' => 'nullable|string',
            'status' => 'required|boolean',
            'client_id' => 'required|integer',
        ];
    }
}
