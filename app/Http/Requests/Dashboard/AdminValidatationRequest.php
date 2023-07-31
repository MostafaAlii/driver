<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AdminValidatationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => $this->filled('status') ? $this->status : 'inactive',
            'link_password_status' => $this->filled('link_password_status') ? $this->link_password_status : 0,
        ]);
    }

    public function rules()
    {
        $this->prepareForValidation();
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'phone' => ['required', 'string', 'max:12'],
            'password' => ['required', 'string', 'min:6'],
            'status' => ['required', 'in:active,inactive'],
            'type' => ['required', 'in:admin,supervisor,general'],
            'link_password_status' => ['sometimes', 'boolean'],
            'country_id' => ['required', 'exists:countries,id'],
        ];
        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $this->route('admins')];
            $rules['password'] = ['nullable', 'string', 'min:6', 'confirmed'];
        }
        return $rules;
    }
}
