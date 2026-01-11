<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;

class ProcessMediaUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected string $tempPath;
    protected string $collection;
    protected string $originalName;
    protected string $disk;

    /**
     * Create a new job instance.
     */
    public function __construct(HasMedia $model, string $tempPath, string $collection, string $originalName, string $disk = 'local')
    {
        $this->model = $model;
        $this->tempPath = $tempPath;
        $this->collection = $collection;
        $this->originalName = $originalName;
        $this->disk = $disk;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fullPath = Storage::disk($this->disk)->path($this->tempPath);

        if (file_exists($fullPath)) {
            $this->model->addMedia($fullPath)
                ->usingFileName($this->originalName)
                ->toMediaCollection($this->collection);

            // Path is automatically deleted by Spatie if we don't use preservingOriginal, 
            // but since we moved it to temp ourselves, let's be sure.
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
    }
}
