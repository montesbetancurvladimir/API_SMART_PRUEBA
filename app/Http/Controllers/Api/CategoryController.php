<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;


class CategoryController extends Controller
{
    // Listar todas las categorías con paginación
    public function index(){
        return response()->json(Category::paginate(10));
    }

    // Mostrar una categoría específica
    public function show($id){
        $category = Category::find($id);
        if (!$category){
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }
        return response()->json($category);
    }

    // Crear una nueva categoría
    public function store(StoreCategoryRequest $request){
        $category = Category::create($request->validated());
        return response()->json($category, 201);
    }

    // Actualizar una categoría existente
    public function update(UpdateCategoryRequest $request, $id){
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }
        $category->update($request->validated());
        return response()->json($category);
    }

    // Eliminar una categoría
    public function destroy($id){
        $category = Category::withCount('products')->find($id);
        if (!$category){
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }
        if ($category->products_count > 0){
            return response()->json(['message' => 'No se puede eliminar la categoría porque tiene productos asociados'], 400);
        }
        $category->delete();
        return response()->json(['message' => 'Categoría eliminada']);
    }
}
