<?php

namespace App\Http\Resources\Api;

use App\Models\PostHarvestServicesDepartmentField;
use App\Models\ServiceField;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if($this->field_type == 'checkbox'){
            $checkboxValues = PostHarvestServicesDepartmentField::where('post_harvest_id', $this->service?->category?->id)
            ->where('type', 'checkbox')
            ->where('name', $this->field_name)
            ->where('status', 'active')
            ->pluck('values')
            ->map(function($value) {
                return json_decode($value, true);
            })
            ->flatten()
            ->toArray();

            $fieldValueArray = explode(',', $this->field_value);

            $checkboxStatus = array_map(function($value) use ($fieldValueArray) {
                return [
                    'name' => $this->field_name,
                    'price' => $this->field_price,
                    'value' => $value,
                    'label' => $value,
                    'selected' => in_array($value, $fieldValueArray)
                ];
            }, $checkboxValues);
        }

        if ($this->field_type == 'dropdown-list') {
            $min_dropdown = ServiceField::where('service_id', $this->service_id)
                ->where('field_type', 'dropdown-list')
                ->where('field_name', $this->field_name)
                ->min('field_price');

            $dropdown_price_min_check = $this->field_price == $min_dropdown;
        }

        return [
            "id" => $this->id,
            "service_id" => $this->service_id,
            "field_name" => $this->field_name,
            "field_value" => $this->field_value,
            "options" => $this->field_type == 'checkbox' ? $checkboxStatus : null,
            "field_type" => $this->field_type,
            "field_price" => $this->field_price,
            "field_min" => $this->field_type == 'dropdown-list' ? $dropdown_price_min_check : false,
            'created_at' => $this->created_at->format("d-m-Y"),
        ];
    }
}
