<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
            'address' => ['required', 'max:255', 'string'],
            'flat_number' => ['required', 'max:255', 'string'],
            'floor' => ['required', 'max:255', 'string'],
            'landmark' => ['required', 'max:255', 'string'],
            'state' => ['required', 'max:255', 'string'],
            'building' => ['required', 'max:255', 'string'],
            'city' => ['required', 'max:255', 'string'],
            'lead_id' => 'required|exists:leads,id',
        ];
    }
}
