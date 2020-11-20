<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquity extends FormRequest
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
            'unit_id' => 'required|integer',
            'total_equity' => 'required|numeric',
            'total_equity_paid' => 'required|numeric',
            'total_penalties' => 'required|numeric',
            'total_penalty_paid' => 'required|numeric',
            'remaining_balance' => 'required|numeric',
            'letter_of_notice_status' => 'required|integer',
            'client_id' => 'required|integer',
            'months_to_pay' => 'required|integer',
            'reservation_date' => 'required|string',
            'monthly_equity' => 'required|numeric'
        ];
    }
}
