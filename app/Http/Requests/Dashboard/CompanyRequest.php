<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function prepareForValidation() {
        $this->merge([
            'status' => $this->filled('status') ? $this->status : 0,
            'admin_id' => get_user_data()->id,
        ]);
    }

    public function rules(): array {
        $this->prepareForValidation();
        return [
            'name' =>'required|max:255',
            'email' =>'required|email|unique:companies,email',
            'status' =>'required|boolean',
            'mobile' =>'required|numeric',
            'landline' =>'nullable|numeric',
            'address' =>'nullable|max:255',
            'postal_code' =>'nullable|numeric',
            'state' =>'nullable|max:255',
            'country_id' =>'required|exists:countries,id',
            'admin_id' =>'nullable|exists:admins,id',
        ];
    }
}
