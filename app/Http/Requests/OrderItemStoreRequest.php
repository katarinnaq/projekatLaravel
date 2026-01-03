<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemStoreRequest extends FormRequest
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
            'porudzbina_id' => ['required', 'integer', 'exists:Order,id'],
            'proizvod_id' => ['required', 'integer', 'exists:Product,id'],
            'kolicina' => ['required', 'integer'],
            'cena' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
        ];
    }
}
