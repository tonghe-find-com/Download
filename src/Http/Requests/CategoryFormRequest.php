<?php

namespace Tonghe\Modules\Downloads\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class CategoryFormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255|required_if:status.*,1|required_with:title.*',
            'status.*' => 'boolean',
            'meta_title.*' => 'nullable|max:255',
            'meta_keywords.*' => 'nullable|max:255',
            'meta_description.*' => 'nullable|max:255',
        ];
    }
}
