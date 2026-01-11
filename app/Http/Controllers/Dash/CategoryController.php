<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    /**
     * Inject CategoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of categories
     */
    public function index(): View
    {
        $categories = $this->categoryService->getAllCategories();

        return view('dash.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create(): View
    {
        return view('dash.categories.create');
    }

    /**
     * Store a newly created category in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $this->categoryService->createCategory($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(int $id): View
    {
        $category = $this->categoryService->getCategoryById($id);

        if (!$category) {
            abort(404, 'Category not found');
        }

        return view('dash.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $updated = $this->categoryService->updateCategory($id, $validated);

        if (!$updated) {
            return redirect()->back()->with('error', 'Category not found');
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from storage
     */
    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->categoryService->deleteCategory($id);

        if (!$deleted) {
            return redirect()->back()->with('error', 'Category not found');
        }

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
