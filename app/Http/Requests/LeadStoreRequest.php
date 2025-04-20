<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'max:255', 'string'],
            'phone2' => ['nullable', 'max:255', 'string'],
            'stage_id' => ['exists:stages,id'],
            'source_id' => ['required', 'exists:sources,id'],
            'follow_date' => ['nullable', 'date'],
            'contract_id' => ['nullable', 'exists:contracts,id'],
            'card_id' => ['nullable', 'exists:cards,id'],
            'user_id' => 'exists:users,id',
        ];
    }
}
