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
            "period_received_id" => "required",
            "period_affected_id" => "required",
            "description" => "nullable|min:5",
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
            "period_received_id.required" => "Tiene que seleccionar un periodo.",
            "period_affected_id.required" => "Tiene que seleccionar un periodo.",
            "description.min" => "La descripción tiene que contener minimo 5 dígitos.",
        ];
    }
}