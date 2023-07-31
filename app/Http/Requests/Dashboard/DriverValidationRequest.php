<?php
namespace App\Http\Requests\Dashboard;
use Illuminate\Foundation\Http\FormRequest;
class DriverValidationRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }
    public function prepareForValidation() {
        $this->merge([
            'status' => $this->filled('status') ? $this->status : 'inactive',
        ]);
    }
    public function rules() {
        $this->prepareForValidation();
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:drivers'],
            'phone' => ['required', 'string', 'max:12'],
            'password' => ['required', 'string', 'min:6'],
            'status' => ['required', 'in:active,inactive'],
            'gender' => ['required', 'in:male,female'],
            'country_id' => ['required', 'exists:countries,id'],
        ];
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:drivers,email,' . $this->route('drivers')];
            $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
        }
        return $rules;
    }
}