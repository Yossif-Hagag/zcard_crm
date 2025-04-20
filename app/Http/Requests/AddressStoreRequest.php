<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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

    public function messages(): array
    {
        return [
            'address.required' => 'The address field is required.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'address.string' => 'The address must be a string.',

            'flat_number.required' => 'The flat number field is required.',
            'flat_number.max' => 'The flat number may not be greater than 255 characters.',
            'flat_number.string' => 'The flat number must be a string.',

            'floor.required' => 'The floor field is required.',
            'floor.max' => 'The floor may not be greater than 255 characters.',
            'floor.string' => 'The floor must be a string.',

            'landmark.required' => 'The landmark field is required.',
            'landmark.max' => 'The landmark may not be greater than 255 characters.',
            'landmark.string' => 'The landmark must be a string.',

            'state.required' => 'The state field is required.',
            'state.max' => 'The state may not be greater than 255 characters.',
            'state.string' => 'The state must be a string.',

            'building.required' => 'The building field is required.',
            'building.max' => 'The building may not be greater than 255 characters.',
            'building.string' => 'The building must be a string.',

            'city.required' => 'The city field is required.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'city.string' => 'The city must be a string.',

            'lead_id.required' => 'The lead ID field is required.',
            'lead_id.exists' => 'The selected lead ID does not exist.',
        ];
    }

}
