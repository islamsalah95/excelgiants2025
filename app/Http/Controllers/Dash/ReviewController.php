<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $service;

    public function __construct(ReviewService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $reviews = $this->service->paginate();
        return view('dash.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('dash.reviews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $this->service->create($request->all());

        return redirect()->route('reviews.index')->with('success', 'Review created successfully.');
    }

    public function edit(Review $review)
    {
        return view('dash.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->service->update($review, $request->all());

        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $this->service->delete($review);
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
