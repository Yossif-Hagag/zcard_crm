<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'customer_name' => ['required', 'max:255', 'string'],
            'customer_phone' => ['required', 'max:255', 'string'],
            'customer_address' => ['required', 'max:255', 'string'],
            'cost' => ['nullable', 'numeric'],
            'order_date' => ['required', 'date'],
            'delivery_date' => ['required', 'date'],
            'status_id' => ['required', 'exists:statuses,id'],
            'card_name' => ['required', 'max:255', 'json'],
            'lead_id' => ['required', 'exists:leads,id'],
        ];
    }
}
