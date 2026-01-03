<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'kategorija_id' => ['required', 'integer', 'exists:Category,id'],
            'tip_vode' => ['required', 'string', 'max:20'],
            'naziv' => ['required', 'string', 'max:30'],
            'opis' => ['nullable', 'string'],
            'cena' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'ambalaza' => ['required', 'string', 'max:20'],
        ];
    }
}
