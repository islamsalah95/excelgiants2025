<?php

namespace App\Services;

use App\Models\ServicesSection;
use Illuminate\Support\Facades\DB;

class ServicesSectionService
{
    public function getAll($activeOnly = false, $limit = null)
    {
        $query = ServicesSection::query();

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
        return ServicesSection::latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $servicesSection = ServicesSection::create($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $servicesSection->addMedia($data['image'])->toMediaCollection('image');
            }

            return $servicesSection;
        });
    }

    public function update(ServicesSection $servicesSection, array $data)
    {
        return DB::transaction(function () use ($servicesSection, $data) {
            $servicesSection->update($data);

            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $servicesSection->clearMediaCollection('image');
                $servicesSection->addMedia($data['image'])->toMediaCollection('image');
            }

            return $servicesSection;
        });
    }

    public function delete(ServicesSection $servicesSection)
    {
        return $servicesSection->delete();
    }
}
