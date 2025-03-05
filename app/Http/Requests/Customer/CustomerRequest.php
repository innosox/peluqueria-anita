<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'identificacion' => 'required|string|unique:customer',
            'email' => 'required|string|email|unique:customer',
            'phone' => 'required|string|max:20',
            'birthday' => 'nullable|string',
            'address' => 'nullable|string',
        ];
    }
}
