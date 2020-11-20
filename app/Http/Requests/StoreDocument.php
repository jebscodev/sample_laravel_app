<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocument extends FormRequest
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
            'cust_prof' => 'nullable|boolean',
            'cust_reg' => 'nullable|boolean',
            'tin_dec' => 'nullable|boolean',
            'ids' => 'nullable|boolean',
            'prof_acq' => 'nullable|boolean',
            'res_agnt' => 'nullable|boolean',
            'prov_rcpt' => 'nullable|boolean',
            'term_sht' => 'nullable|boolean',
            'birth_cert' => 'nullable|boolean',
            'marriage_cert' => 'nullable|boolean',
            'cenomar' => 'nullable|boolean',
            'proof_of_income' => 'nullable|boolean',
            'proof_of_billing' => 'nullable|boolean',
            'pdc' => 'nullable|boolean',
            //'requirements_status' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'date_completed' => 'nullable|string',
            'remarks' => 'nullable|string'
        ];
    }
}
