<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEquipmentRequest extends FormRequest
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
            'name' => 'required|max:50',
            'brand' => 'nullable|max:30',
            'model' => 'nullable|max:30',
            'serial_number' => 'nullable|max:30',
            'description' => 'nullable',
            'purchase_date' => 'nullable|date',
            'purchase_value' => 'nullable|numeric',
            'depreciated_value' => 'nullable|numeric',
            'deprciation_value' => 'nullable|numeric',
            'current_value' => 'nullable|numeric',
            'use_of_equipment' => 'nullable',
            'active' => 'nullable|boolean',
            'location' => 'nullable',
            'manual_url' => 'nullable',
            'manual_file_location' => 'nullable',
            'procedure_location' => 'nullable',
            'schematics_location' => 'nullable',
            'service_by_days' => 'nullable|numeric'
        ];
    }
}
