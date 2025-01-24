<?php
namespace App\Services;

use App\Models\Category;

class CategoryService
{

    public function getCategoryById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public function updateCategory($Category, array $data): Category
    {
        $Category->update($data);
        return $Category;
    }

    public function destroyById($id)
    {
        $Category = Category::find($id);

        if (! $Category) {
            return false;
        }
        return $Category->delete(); // Devuelve true si la eliminación fue exitosa
    }

}
