<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'employee_id' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email_address' => 'required|email:rfc,dns|unique:App\User',
            'username' => 'required|string|unique:App\User',
            'password' => 'required|string', // might change
            'status' => 'required|boolean',
            'role_id' => 'required|integer'
        ];
    }
}
