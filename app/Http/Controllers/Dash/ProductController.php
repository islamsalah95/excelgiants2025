<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected CategoryService $categoryService;
    protected TagService $tagService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        TagService $tagService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of products
     */
    public function index(): View
    {
        $products = $this->productService->getAllProducts();

        return view('dash.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create(): View
    {
        $categories = $this->categoryService->getAllCategories();
        $tags = $this->tagService->getAllTags();

        return view('dash.products.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created product in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_free' => 'nullable|boolean',
            'is_program' => 'nullable|boolean',
            'download_link' => 'nullable|url',
            'is_active' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|max:5120', // 5MB max
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:15360', // 15MB max
        ]);

        $validated['is_free'] = $request->has('is_free');
        $validated['is_program'] = $request->has('is_program');
        $validated['is_active'] = $request->has('is_active');

        $product = $this->productService->createProduct($validated);

        // Handle main image upload using Spatie Media
        if ($request->hasFile('image')) {
            $product->addMedia($request->file('image'))
                ->toMediaCollection('main_image');
        }

        // Handle gallery images using Spatie Media
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryFile) {
                $product->addMedia($galleryFile)
                    ->toMediaCollection('gallery');
            }
        }

        return redirect()->route('products.upload-download', $product->id)
            ->with('success', 'Product details saved. Now please upload the download file.');
    }

    /**
     * Show the form to upload download file
     */
    public function uploadDownloadForm(int $id): View
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        return view('dash.products.upload_download', compact('product'));
    }

    /**
     * Save the download file for a product
     */
    public function saveDownloadFile(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'file' => 'required|file|max:512000', // 500MB = 512000 KB
        ]);

        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        try {
            // Clear existing download file
            $product->clearMediaCollection('downloads');

            // Add new download file using Spatie Media
            $product->addMedia($request->file('file'))
                ->toMediaCollection('downloads');

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Download file upload error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to upload file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(int $id): View
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        $categories = $this->categoryService->getAllCategories();
        $tags = $this->tagService->getAllTags();

        return view('dash.products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * Display the specified product profile
     */
    public function show(int $id): View
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        return view('dash.products.show', compact('product'));
    }

    /**
     * Update the specified product in storage
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_free' => 'nullable|boolean',
            'is_program' => 'nullable|boolean',
            'download_link' => 'nullable|url',
            'is_active' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|max:5120', // 5MB max
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:15360', // 15MB max
        ]);

        $validated['is_free'] = $request->has('is_free');
        $validated['is_program'] = $request->has('is_program');
        $validated['is_active'] = $request->has('is_active');

        $updated = $this->productService->updateProduct($id, $validated);

        if (!$updated) {
            return redirect()->back()->with('error', 'Product not found');
        }

        // Get the product for media handling
        $product = $this->productService->getProductById($id);

        // Handle main image upload using Spatie Media
        if ($request->hasFile('image')) {
            // Clear existing main image
            $product->clearMediaCollection('main_image');
            // Add new main image
            $product->addMedia($request->file('image'))
                ->toMediaCollection('main_image');
        }

        // Handle gallery images using Spatie Media
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryFile) {
                $product->addMedia($galleryFile)
                    ->toMediaCollection('gallery');
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage
     */
    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->productService->deleteProduct($id);

        if (!$deleted) {
            return redirect()->back()->with('error', 'Product not found');
        }

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
