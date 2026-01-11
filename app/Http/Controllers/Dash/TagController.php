<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    protected TagService $tagService;

    /**
     * Inject TagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of tags
     */
    public function index(): View
    {
        $tags = $this->tagService->getAllTags();

        return view('dash.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag
     */
    public function create(): View
    {
        return view('dash.tags.create');
    }

    /**
     * Store a newly created tag in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $this->tagService->createTag($validated);

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully!');
    }

    /**
     * Show the form for editing the specified tag
     */
    public function edit(int $id): View
    {
        $tag = $this->tagService->getTagById($id);

        if (!$tag) {
            abort(404, 'Tag not found');
        }

        return view('dash.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag in storage
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $updated = $this->tagService->updateTag($id, $validated);

        if (!$updated) {
            return redirect()->back()->with('error', 'Tag not found');
        }

        return redirect()->route('tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified tag from storage
     */
    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->tagService->deleteTag($id);

        if (!$deleted) {
            return redirect()->back()->with('error', 'Tag not found');
        }

        return redirect()->route('tags.index')
            ->with('success', 'Tag deleted successfully!');
    }
}
