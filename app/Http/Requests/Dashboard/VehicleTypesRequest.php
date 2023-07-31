<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class VehicleTypesRequest extends FormRequest
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
            'icon' => 'required',
            'capacity' => 'required',
            'is_accept_share_ride' => 'required|boolean',
            'status' => 'required|boolean',
        ];
    }
}
