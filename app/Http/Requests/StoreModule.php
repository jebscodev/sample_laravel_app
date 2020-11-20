<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModule extends FormRequest
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
            'description' => 'nullable|string',
            'url' => 'required|string',
            'is_module' => 'required|boolean',
            'is_child' => 'required|boolean',
            'menu_parent_id' => 'nullable|integer',
            'icon' => 'nullable|string',
            'status' => 'required|boolean'
        ];
    }
}
