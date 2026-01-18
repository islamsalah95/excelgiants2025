<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    public function getAll($activeOnly = false, $limit = null)
    {
        $query = Review::query();

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        $query->latest();

        if ($limit) {
            return $query->limit($limit)->get();
        }

        return $query->get();
    }

    public function paginate($perPage = 10)
    {
        return Review::latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $review = Review::create($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $review->addMedia($data['image'])->toMediaCollection('image');
            }

            return $review;
        });
    }

    public function update(Review $review, array $data)
    {
        return DB::transaction(function () use ($review, $data) {
            $review->update($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $review->clearMediaCollection('image');
                $review->addMedia($data['image'])->toMediaCollection('image');
            }

            return $review;
        });
    }

    public function delete(Review $review)
    {
        return $review->delete();
    }
}
