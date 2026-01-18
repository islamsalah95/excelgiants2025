<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Services\AboutSectionService;
use Illuminate\Http\Request;

class AboutSectionController extends Controller
{
    protected $service;

    public function __construct(AboutSectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $aboutSections = $this->service->paginate();
        return view('dash.about_sections.index', compact('aboutSections'));
    }

    public function create()
    {
        return view('dash.about_sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $this->service->create($request->all());

        return redirect()->route('about-sections.index')->with('success', 'About section created successfully.');
    }

    public function edit(AboutSection $aboutSection)
    {
        return view('dash.about_sections.edit', compact('aboutSection'));
    }

    public function update(Request $request, AboutSection $aboutSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->service->update($aboutSection, $request->all());

        return redirect()->route('about-sections.index')->with('success', 'About section updated successfully.');
    }

    public function destroy(AboutSection $aboutSection)
    {
        $this->service->delete($aboutSection);
        return redirect()->route('about-sections.index')->with('success', 'About section deleted successfully.');
    }
}
