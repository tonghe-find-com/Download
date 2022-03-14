<?php

namespace TypiCMS\Modules\Downloads\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image_id' => 'nullable|integer',
            'title.*' => 'nullable|max:255',
            'status.*' => 'boolean',
            'category_id' => 'required|integer',
            'show_date' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            "category_id.required" => __("The category is required"),
        ];
    }
}
