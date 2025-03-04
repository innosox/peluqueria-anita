<?php

namespace App\Http\Requests\Attention;

use Illuminate\Foundation\Http\FormRequest;

class AttentionRequest extends FormRequest
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
            'appointment_id' => 'required|exists:appointments,id',
            'service_id' => 'required|exists:service,id',
            'detail' => 'required|string|max:255',
            'price' => 'nullable|numeric',
        ];
    }
}
