<?php

namespace App\Services;

use App\Models\AboutSection;
use Illuminate\Support\Facades\DB;

class AboutSectionService
{
    public function getAll($activeOnly = false, $limit = null)
    {
        $query = AboutSection::query();

        if ($activeOnly) {
            $query->where('is_active', true);
        }

        $query->latest();

        if ($limit) {
            return $query->limit($limit)->get();
        }

        return $query->get(); // Or paginate if needed for dashboard
    }

    public function paginate($perPage = 10)
    {
        return AboutSection::latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $aboutSection = AboutSection::create($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $aboutSection->addMedia($data['image'])->toMediaCollection('image');
            }

            return $aboutSection;
        });
    }

    public function update(AboutSection $aboutSection, array $data)
    {
        return DB::transaction(function () use ($aboutSection, $data) {
            $aboutSection->update($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $aboutSection->clearMediaCollection('image');
                $aboutSection->addMedia($data['image'])->toMediaCollection('image');
            }

            return $aboutSection;
        });
    }

    public function delete(AboutSection $aboutSection)
    {
        return $aboutSection->delete();
    }
}
