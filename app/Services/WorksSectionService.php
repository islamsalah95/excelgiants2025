<?php

namespace App\Services;

use App\Models\WorksSection;
use Illuminate\Support\Facades\DB;

class WorksSectionService
{
    public function getAll($activeOnly = false, $limit = null)
    {
        $query = WorksSection::query();

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        // Ordered by step_number or id
        $query->orderBy('step_number')->latest();

        if ($limit) {
            return $query->limit($limit)->get();
        }

        return $query->get();
    }

    public function paginate($perPage = 10)
    {
        return WorksSection::orderBy('step_number')->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $worksSection = WorksSection::create($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $worksSection->addMedia($data['image'])->toMediaCollection('image');
            }

            return $worksSection;
        });
    }

    public function update(WorksSection $worksSection, array $data)
    {
        return DB::transaction(function () use ($worksSection, $data) {
            $worksSection->update($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $worksSection->clearMediaCollection('image');
                $worksSection->addMedia($data['image'])->toMediaCollection('image');
            }

            return $worksSection;
        });
    }

    public function delete(WorksSection $worksSection)
    {
        return $worksSection->delete();
    }
}
