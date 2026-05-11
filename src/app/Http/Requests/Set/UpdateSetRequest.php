<?php

namespace App\Http\Requests\Set;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['sometimes', 'string', 'max:10', 'unique:sets,code,'.$this->route('set')],
            'name' => ['sometimes', 'string', 'max:255'],
            'release_date_jp' => ['sometimes', 'date'],
            'release_date_global' => ['sometimes', 'date'],
            'total_cards' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
