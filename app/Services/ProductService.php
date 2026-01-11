<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Jobs\ProcessMediaUploadJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Get all products with relationships
     */
    public function getAllProducts()
    {
        return Product::with(['category', 'tags', 'media'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get product by ID with relationships
     */
    public function getProductById(int $id): ?Product
    {
        return Product::with(['category', 'tags', 'media'])->find($id);
    }

    /**
     * Create a new product
     */
    public function createProduct(array $data): Product
    {
        // Create product
        $product = Product::create($data);

        // Handle main image via temp path
        if (isset($data['temp_image']) && !empty($data['temp_image'])) {
            $this->dispatchMediaJobFromPath($product, $data['temp_image'], 'main_image');
        }

        // Handle download file via temp path
        if (isset($data['temp_download_file']) && !empty($data['temp_download_file'])) {
            $this->dispatchMediaJobFromPath($product, $data['temp_download_file'], 'downloads');
        }

        // Sync tags
        if (isset($data['tags'])) {
            $product->tags()->sync($data['tags']);
        }

        return $product;
    }

    /**
     * Update existing product
     */
    public function updateProduct(int $id, array $data): bool
    {
        $product = $this->getProductById($id);

        if (!$product) {
            return false;
        }

        // Handle main image via temp path
        if (isset($data['temp_image']) && !empty($data['temp_image'])) {
            $product->clearMediaCollection('main_image');
            $this->dispatchMediaJobFromPath($product, $data['temp_image'], 'main_image');
        }

        // Handle download file via temp path
        if (isset($data['temp_download_file']) && !empty($data['temp_download_file'])) {
            $product->clearMediaCollection('downloads');
            $this->dispatchMediaJobFromPath($product, $data['temp_download_file'], 'downloads');
        }

        // Update product
        $product->update($data);

        // Sync tags
        if (isset($data['tags'])) {
            $product->tags()->sync($data['tags']);
        }

        return true;
    }

    /**
     * Update only the download file for a product
     */
    public function updateProductDownloadFile(int $id, string $tempPath): bool
    {
        $product = $this->getProductById($id);

        if (!$product) {
            return false;
        }

        if (!empty($tempPath)) {
            $product->clearMediaCollection('downloads');
            $this->dispatchMediaJobFromPath($product, $tempPath, 'downloads');
        }

        return true;
    }

    /**
     * Delete product
     */
    public function deleteProduct(int $id): bool
    {
        $product = $this->getProductById($id);

        if (!$product) {
            return false;
        }

        // Media Library will automatically delete associated media
        return $product->delete();
    }

    /**
     * Add product images (gallery) via Job
     */
    public function addProductImages(int $productId, array $paths): void
    {
        $product = $this->getProductById($productId);

        if (!$product) {
            return;
        }

        foreach ($paths as $path) {
            if (!empty($path)) {
                $this->dispatchMediaJobFromPath($product, $path, 'gallery');
            }
        }
    }

    /**
     * Helper to dispatch process job from existing temp path
     */
    protected function dispatchMediaJobFromPath($model, string $path, string $collection)
    {
        if (Storage::disk('local')->exists($path)) {
            $originalName = basename($path); // We could store real names if needed, but for now basename works

            ProcessMediaUploadJob::dispatch(
                $model,
                $path,
                $collection,
                $originalName,
                'local'
            );
        }
    }

    /**
     * Remove product image from gallery
     */
    public function removeProductImage(int $imageId): bool
    {
        $image = ProductImage::find($imageId);

        if (!$image) {
            return false;
        }

        return $image->delete();
    }

    /**
     * Remove media by ID
     */
    public function removeMedia(int $mediaId): bool
    {
        $media = Media::find($mediaId);

        if (!$media) {
            return false;
        }

        $media->delete();
        return true;
    }
}
