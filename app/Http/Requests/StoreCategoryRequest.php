<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ];
    }

    public function attributes() {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe superar los 255 caracteres.',
            'name.unique' => 'Ya existe una categoría con ese nombre.',

            'description.string' => 'El campo descripción debe ser una cadena de texto.',
        ];
    }
}
