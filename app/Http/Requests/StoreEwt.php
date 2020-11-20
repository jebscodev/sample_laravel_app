<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEwt extends FormRequest
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
            'ewt_amount' => 'required|numeric',
            'rcp_date' => 'nullable|string',
            'est_release_date' => 'nullable|string',
            'actual_release_date' => 'nullable|string',
            'date_paid' => 'nullable|string',
            'total_days' => 'required|integer',
            'kra' => 'required|integer',
            'client_id' => 'required|integer'
        ];
    }
}
