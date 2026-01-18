<?php

namespace App\Services;

use App\Models\VisionSection;
use Illuminate\Support\Facades\DB;

class VisionSectionService
{
    public function getAll($activeOnly = false, $limit = null)
    {
        $query = VisionSection::query();

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
        return VisionSection::latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $visionSection = VisionSection::create($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $visionSection->addMedia($data['image'])->toMediaCollection('image');
            }

            return $visionSection;
        });
    }

    public function update(VisionSection $visionSection, array $data)
    {
        return DB::transaction(function () use ($visionSection, $data) {
            $visionSection->update($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $visionSection->clearMediaCollection('image');
                $visionSection->addMedia($data['image'])->toMediaCollection('image');
            }

            return $visionSection;
        });
    }

    public function delete(VisionSection $visionSection)
    {
        return $visionSection->delete();
    }
}
