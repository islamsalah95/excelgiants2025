<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Remove the specified media from storage
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->productService->removeMedia($id);

        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'Media not found'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Media deleted successfully']);
    }
}
