<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
            'temp_image' => 'nullable|string',
            'temp_download_file' => 'nullable|string',
            'temp_gallery_images' => 'nullable|array',
            'temp_gallery_images.*' => 'string',
        ]);

        $validated['is_free'] = $request->has('is_free');
        $validated['is_program'] = $request->has('is_program');
        $validated['is_active'] = $request->has('is_active');

        $product = $this->productService->createProduct($validated);

        // Handle gallery images
        if ($request->has('temp_gallery_images')) {
            $this->productService->addProductImages($product->id, $request->input('temp_gallery_images'));
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
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
            'temp_image' => 'nullable|string',
            'temp_download_file' => 'nullable|string',
            'temp_gallery_images' => 'nullable|array',
            'temp_gallery_images.*' => 'string',
        ]);

        $validated['is_free'] = $request->has('is_free');
        $validated['is_program'] = $request->has('is_program');
        $validated['is_active'] = $request->has('is_active');

        $updated = $this->productService->updateProduct($id, $validated);

        if (!$updated) {
            return redirect()->back()->with('error', 'Product not found');
        }

        // Handle gallery images
        if ($request->has('temp_gallery_images')) {
            $this->productService->addProductImages($id, $request->input('temp_gallery_images'));
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
