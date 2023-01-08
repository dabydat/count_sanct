<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContributionRequest extends FormRequest
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
            "students" => "required",
            "categories" => "required",
            "contribution_date" => "required",
            "amount" => "required",
            "periods_received" => "required",
            "periods_affected" => "required",
            "description" => "nullable|min:5",
            "bs_amount" => "nullable|min:2",
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            "students.required" => "Tiene que seleccionar un estudiante.",
            "categories.required" => "Tiene que seleccionar una categoría.",
            "contribution_date.required" => "La fecha del aporte es importante.",
            "amount.required" => "El monto del aporte no debe faltar.",
            "periods_received.required" => "Tiene que seleccionar un periodo de recibo.",
            "periods_affected.required" => "Tiene que seleccionar un periodo afectado.",
            "description.min" => "La descripción tiene que contener minimo 5 dígitos.",
            "bs_amount.min" => "El monto en bolivares debe tener minimo 2 dígitos.",
        ];
    }
}