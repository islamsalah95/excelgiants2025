<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\AboutSection;
use App\Models\VisionSection;
use App\Models\ServicesSection;
use App\Models\WorksSection;
use App\Models\Review;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class MainHomeController extends Controller
{



    public function index(Request $request)
    {
        // Filters from query string
        $category = $request->get('category');
        $year = $request->get('year');
        $order = $request->get('order');

        // Data
        $categories = Category::all();
        $years = [2024, 2025, 2026, 2027, 2028, 2029, 2030];

        // Fetch About Sections
        $aboutSections = AboutSection::where('is_active', true)->latest()->get();

        // Fetch Vision Sections
        $visionSections = VisionSection::where('is_active', true)->latest()->get();

        // Fetch Services Sections
        $servicesSections = ServicesSection::where('is_active', true)->latest()->get();

        // Fetch Works Sections
        $worksSections = WorksSection::where('is_active', true)->orderBy('step_number')->latest()->get();

        // Fetch Reviews
        $reviews = Review::where('is_active', true)->latest()->get();

        // Fetch Contact Infos
        $contactInfos = ContactInfo::where('is_active', true)->latest()->get();

        // Query
        $query = Product::query()->where('is_active', true);

        // Category filter
        if ($category) {
            $query->where('category_id', $category);
        }

        // Year filter
        if ($year) {
            $query->whereYear('created_at', $year);
        }

        // Order filter (SAFE & CONSISTENT)
        match ($order) {
            'latest' => $query->latest(),
            'rating' => $query->orderBy('rating', 'desc'),
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        // Paginate LAST
        $products = $query->paginate(8)->withQueryString();

        return view('welcome', compact(
            'products',
            'categories',
            'years',
            'category',
            'year',
            'order',
            'aboutSections',
            'visionSections',
            'servicesSections',
            'worksSections',
            'reviews',
            'contactInfos'
        ));
    }



}
