<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanTakeout extends FormRequest
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
            'financing_scheme' => 'required|integer',
            'loan_status' => 'required|integer',
            'loan_amount' => 'required|numeric',
            'tcp' => 'required|numeric',
            'variance' => 'required|numeric',
            'status' => 'required|boolean',
            'total_days' => 'required|integer',
            'kra' => 'required|integer',
            'client_id' => 'required|integer'
        ];
    }
}
