<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TagService
{
    /**
     * Get all tags with optional pagination
     *
     * @param bool $paginate
     * @param int $perPage
     * @return LengthAwarePaginator|Collection
     */
    public function getAllTags(bool $paginate = false, int $perPage = 10)
    {
        $query = Tag::orderBy('created_at', 'desc');

        return $paginate ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Get tag by ID
     *
     * @param int $id
     * @return Tag|null
     */
    public function getTagById(int $id): ?Tag
    {
        return Tag::find($id);
    }

    /**
     * Create a new tag
     *
     * @param array $data
     * @return Tag
     */
    public function createTag(array $data): Tag
    {
        return Tag::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Update existing tag
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateTag(int $id, array $data): bool
    {
        $tag = $this->getTagById($id);

        if (!$tag) {
            return false;
        }

        return $tag->update([
            'name' => $data['name'] ?? $tag->name,
            'description' => $data['description'] ?? $tag->description,
            'is_active' => $data['is_active'] ?? $tag->is_active,
        ]);
    }

    /**
     * Delete tag
     *
     * @param int $id
     * @return bool
     */
    public function deleteTag(int $id): bool
    {
        $tag = $this->getTagById($id);

        if (!$tag) {
            return false;
        }

        return $tag->delete();
    }

    /**
     * Toggle tag active status
     *
     * @param int $id
     * @return bool
     */
    public function toggleStatus(int $id): bool
    {
        $tag = $this->getTagById($id);

        if (!$tag) {
            return false;
        }

        $tag->is_active = !$tag->is_active;
        return $tag->save();
    }
}
