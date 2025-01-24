<?php
namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest\IndexCategoryRequest;
use App\Http\Requests\CategoryRequest\StoreCategoryRequest;
use App\Http\Requests\CategoryRequest\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categorytService;

    public function __construct(CategoryService $categorytService)
    {
        $this->categorytService = $categorytService;
    }

    public function list(IndexCategoryRequest $request)
    {

        return $this->getFilteredResults(
            Category::class,
            $request,
            Category::filters,
            Category::sorts,
            CategoryResource::class
        );
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categorytService->createCategory($request->validated());
        return new CategoryResource($category);
    }
    public function update(UpdateCategoryRequest $request, $id)
    {
        $validatedData = $request->validated();

        $category = $this->categorytService->getCategoryById($id);
        if (! $category) {
            return response()->json([
                'error' => 'Categorya no encontrada',
            ], 404);
        }

        $updatedCompany = $this->categorytService->updateCategory($category, $validatedData);
        return new CategoryResource($updatedCompany);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json([
                'message' => 'Categoria no encontrado.',
            ], 404);
        }

        if ($category->contestants()->exists()) {
            return response()->json([
                'message' => 'El concurso tiene concursantes asociados.',
            ], 422);
        }

        $category->delete();

        return response()->json([
            'message' => 'Categoria eliminado exitosamente.',
        ], 200);
    }
}
