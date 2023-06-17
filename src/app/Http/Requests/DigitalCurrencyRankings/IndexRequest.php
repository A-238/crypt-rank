<?php

declare(strict_types=1);

namespace App\Http\Requests\DigitalCurrencyRankings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'limit' => ['nullable', 'integer', 'min:1', 'max:500'],
            'sort' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }

    /**
     * @return void
     */
    public function passedValidation(): void
    {
        $this->merge([
            'limit' => (int)$this->input('limit'),
        ]);
    }
}
