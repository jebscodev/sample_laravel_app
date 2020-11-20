<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquityBreakdown extends FormRequest
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
            'equity_no' => 'required|integer',
            'due_date' => 'required|string',
            'monthly_equity' => 'required|numeric',
            'penalty' => 'required|numeric',
            'payment_status' => 'required|boolean',
            'equity_id' => 'required|integer',
            'equity_payment_id' => 'nullable|integer'
        ];
    }
}
