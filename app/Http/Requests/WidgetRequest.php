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

    public function width(): int
    {
        return (int)($this->get('width') ?? 100);
    }

    public function height(): int
    {
        return (int)($this->get('height') ?? 100);
    }

    public function textColor(): string
    {
        return '#' . ($this->get('text_color') ?? 'fff');
    }

    public function backgroundColor(): string
    {
        return '#' . ($this->get('background_color') ?? '000');
    }
}
