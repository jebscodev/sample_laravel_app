<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest
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
            'name' => 'required|string',
            'location' => 'required|string',
            'area' => 'required|numeric',
            'price_variation' => 'required|numeric',
            'base_price' => 'required|numeric',
            'standard_floor_area' => 'required|numeric',
            'excess_of_sqm' => 'required|numeric',
            'price_per_sqm' => 'required|numeric',
            'premium' => 'required|numeric',
            'commission' => 'required|numeric',
            'nsp' => 'required|numeric',
            'vat' => 'required|numeric',
            'reg_fee' => 'required|numeric',
            'transfer_tax' => 'required|numeric',
            'doc_stamps' => 'required|numeric',
            'required_dp' => 'required|numeric',
            'misc_home_auto' => 'required|numeric',
            'status' => 'required|boolean'
        ];
   }
}
