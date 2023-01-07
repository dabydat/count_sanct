<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            "name"  => "required|min:3",
            "last_name"  => "nullable|min:3",
            "email"  => "required|unique:students|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",
            "dni"  => "nullable|int|min:3",
            "phone"  => "nullable|min:10",

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
            "name.required" => "El nombre del estudiante es requerido.",
            "name.min" => "El nombre del estudiante minimo de 3 caracteres.",
            "email.required" => "El correo del estudiante es requerido.",
            "email.unique" => "Este correo ya existe, por favor intente nuevamente.",
            "email.regex" => "No cumple con la forma de un correo, intente nuevamente.",
            "dni.int" => "La cedula debe ser un numero.",
            "phone.min" => "El numero no puede ser menor de diez digitos.",
        ];
    }
}
