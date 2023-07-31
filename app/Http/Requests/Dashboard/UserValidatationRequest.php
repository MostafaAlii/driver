<?php
namespace App\Http\Requests\Dashboard;
use Illuminate\Foundation\Http\FormRequest;
class UserValidatationRequest extends FormRequest {
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'phone' => ['required', 'string', 'max:12'],
            'password' => ['required', 'string', 'min:6'],
            'status' => ['required', 'in:active,inactive'],
        ];
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $this->route('users')];
            $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
        }
        return $rules;
    }
}