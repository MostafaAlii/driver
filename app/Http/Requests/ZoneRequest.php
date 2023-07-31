<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZoneRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'service_location_id' => 'required|exists:service_locations,id',
            'name' => 'required|string',
            'unit' => 'required|string',
            'coordinates' => 'required',
            'status' => 'required|boolean',
        ];
    }
}
