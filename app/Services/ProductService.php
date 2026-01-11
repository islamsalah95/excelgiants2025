<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media; // Added for Media Library

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

        // Handle main image upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $product->addMedia($data['image'])
                ->toMediaCollection('main_image');
        }

        // Handle download file upload
        if (isset($data['download_file']) && $data['download_file'] instanceof UploadedFile) {
            $product->addMedia($data['download_file'])
                ->toMediaCollection('downloads');
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

        // Handle main image upload (replaces existing)
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $product->clearMediaCollection('main_image');
            $product->addMedia($data['image'])
                ->toMediaCollection('main_image');
        }

        // Handle download file upload (replaces existing)
        if (isset($data['download_file']) && $data['download_file'] instanceof UploadedFile) {
            $product->clearMediaCollection('downloads');
            $product->addMedia($data['download_file'])
                ->toMediaCollection('downloads');
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
     * Add product images (gallery)
     */
    public function addProductImages(int $productId, array $images): void
    {
        $product = $this->getProductById($productId);

        if (!$product) {
            return;
        }

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $product->addMedia($image)
                    ->toMediaCollection('gallery');
            }
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
