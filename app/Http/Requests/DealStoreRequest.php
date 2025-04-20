<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealStoreRequest extends FormRequest
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
            'cost' => ['required', 'numeric'],
            'deal_date' => ['required', 'date'],
            'delivery_date' => ['required', 'date'],
            'card_name' => ['required', 'max:255', 'json'],
            'lead_id' => ['required', 'exists:leads,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'defaultname' => ['required', 'max:255', 'string'],
            'defaultphone' => ['required', 'max:255', 'numeric'],
            'time' => ['required', 'time'],
        ];
    }
}
