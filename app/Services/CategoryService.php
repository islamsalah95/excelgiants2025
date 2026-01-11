<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * Get all categories with optional pagination
     *
     * @param bool $paginate
     * @param int $perPage
     * @return LengthAwarePaginator|Collection
     */
    public function getAllCategories(bool $paginate = false, int $perPage = 10)
    {
        $query = Category::orderBy('created_at', 'desc');

        return $paginate ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Get category by ID
     *
     * @param int $id
     * @return Category|null
     */
    public function getCategoryById(int $id): ?Category
    {
        return Category::find($id);
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Update existing category
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateCategory(int $id, array $data): bool
    {
        $category = $this->getCategoryById($id);

        if (!$category) {
            return false;
        }

        return $category->update([
            'name' => $data['name'] ?? $category->name,
            'description' => $data['description'] ?? $category->description,
            'is_active' => $data['is_active'] ?? $category->is_active,
        ]);
    }

    /**
     * Delete category
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory(int $id): bool
    {
        $category = $this->getCategoryById($id);

        if (!$category) {
            return false;
        }

        return $category->delete();
    }

    /**
     * Toggle category active status
     *
     * @param int $id
     * @return bool
     */
    public function toggleStatus(int $id): bool
    {
        $category = $this->getCategoryById($id);

        if (!$category) {
            return false;
        }

        $category->is_active = !$category->is_active;
        return $category->save();
    }
}
