<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        $productId = $this->route('product');
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name,' . $productId,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }

    public function attributes(){
        return [
            'category_id' => 'categoría',
            'name' => 'nombre',
            'description' => 'descripción',
            'price' => 'precio',
            'stock' => 'inventario',
        ];
    }

    public function messages(){
        return [
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'name.unique' => 'Ya existe un producto con este nombre.',

            'description.string' => 'La descripción debe ser una cadena de texto.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un valor numérico.',
            'price.min' => 'El precio no puede ser negativo.',

            'stock.required' => 'El inventario es obligatorio.',
            'stock.integer' => 'El inventario debe ser un número entero.',
            'stock.min' => 'El inventario no puede ser negativo.',
        ];
    }
}
