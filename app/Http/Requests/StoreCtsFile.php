<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCtsFile extends FormRequest
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
            'date_printed' => 'nullable|string',
            'date_signed' => 'nullable|string',
            'date_notarized' => 'nullable|string',
            'cts_status' => 'required|boolean',
            'total_days' => 'required|integer',
            'kra' => 'required|integer',
            'client_id' => 'required|integer'
        ];
    }
}
