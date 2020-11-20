<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBroker extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'nullable|string',
            'tin_no' => 'nullable|string',
            'brokerage_firm' => 'nullable|string',
            'email_address' => 'nullable|string',
            'contact_no' => 'nullable|string',
            'payment_schedule' => 'required|integer',
            'status' => 'required|boolean'
        ];
    }
}
