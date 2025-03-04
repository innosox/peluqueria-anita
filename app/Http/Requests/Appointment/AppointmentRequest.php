<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
            'customer_id' => 'required|exists:customer,id',
            'service_id' => 'required|exists:service,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|time',
            'status' => 'in:pendiente,realizada,cancelada',
            'reason' => 'required|string|max:255',
        ];
    }
}
