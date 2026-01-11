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
            'temp_image' => 'nullable|string',
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
     * Save the download file for a product (supports chunking)
     */
    public function saveDownloadFile(Request $request, int $id): JsonResponse
    {
        $file = $request->file('file');
        if (!$file) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $chunkIndex = $request->input('dzchunkindex');
        $totalChunks = $request->input('dztotalchunkcount');
        $uuid = $request->input('dzuuid');

        if ($totalChunks !== null) {
            $tempPath = "temp/chunks/{$uuid}";
            $chunkName = "{$chunkIndex}.part";

            \Illuminate\Support\Facades\Storage::disk('local')->putFileAs($tempPath, $file, $chunkName);

            // Check if all chunks are uploaded
            $chunks = \Illuminate\Support\Facades\Storage::disk('local')->files($tempPath);
            if (count($chunks) == $totalChunks) {
                // Merge chunks
                $originalName = $request->input('dzfilename') ?? $file->getClientOriginalName();
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $finalName = \Illuminate\Support\Str::random(40) . ($extension ? '.' . $extension : '');
                $finalDir = 'temp/' . date('Y-m-d');
                $finalPath = "{$finalDir}/{$finalName}";

                if (!\Illuminate\Support\Facades\Storage::disk('local')->exists($finalDir)) {
                    \Illuminate\Support\Facades\Storage::disk('local')->makeDirectory($finalDir);
                }

                $out = fopen(\Illuminate\Support\Facades\Storage::disk('local')->path($finalPath), "wb");
                for ($i = 0; $i < $totalChunks; $i++) {
                    $chunkFile = \Illuminate\Support\Facades\Storage::disk('local')->path("{$tempPath}/{$i}.part");
                    $in = fopen($chunkFile, "rb");
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                    fclose($in);
                    @unlink($chunkFile);
                }
                fclose($out);
                \Illuminate\Support\Facades\Storage::disk('local')->deleteDirectory($tempPath);

                // Finalize product attachment
                $this->productService->updateProductDownloadFile($id, $finalPath);

                return response()->json([
                    'path' => $finalPath,
                    'success' => true
                ]);
            }

            return response()->json(['chunk' => $chunkIndex, 'success' => true]);
        }

        // Single file upload
        $tempDir = 'temp/' . date('Y-m-d');
        $tempName = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($tempDir, $tempName, 'local');

        // Finalize product attachment
        $this->productService->updateProductDownloadFile($id, $path);

        return response()->json([
            'path' => $path,
            'success' => true
        ]);
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
