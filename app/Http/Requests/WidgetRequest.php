<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WidgetRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'width' => 'integer|between:100,500|nullable',
            'height' => 'integer|between:100,500|nullable',
            'text_color' => 'string|regex:/^[0-9A-Fa-f]{3,6}$/|nullable',
            'background_color' => 'string|regex:/^[0-9A-Fa-f]{3,6}$/|nullable',
        ];
    }
}
