<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseEquipmentRequest extends FormRequest
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
        $today = date('Ymd');
        $unique = Rule::unique('equipment')->ignore($this->equipment->id ?? null);

        return [
            "number"                => ["required", "alpha_num", "max:6", $unique],
            "brand"                 => "alpha_dash|max:50",
            "model"                 => "alpha_dash|max:50",
            "serial_number"         => "alpha_dash|max:50",
            "description"           => "nullable",
            "weight"                => "integer|digits_between:0,4",
            "purchase_date"         => "date|before_or_equal:{$today}",
            "purchase_value"        => "numeric|min:0|nullable",
            "depreciation_amount"   => "numeric|min:0|max:{$this->purchase_value}|nullable",
            "use_of_equipment"      => "max:100|nullable",
            "manual_url"            => "url|nullable",
            "service_by_days"       => "integer|between:0,365",
            "size_x"                => "numeric|min:0",
            "size_y"                => "numeric|min:0",
            "size_z"                => "numeric|min:0",
            "account_asset_number"  => "alpha_dash|max:50|nullable",
            "department_id"         => "exists:departments,id",
            "status_id"             => "exists:statuses,id"
        ];
    }
}
