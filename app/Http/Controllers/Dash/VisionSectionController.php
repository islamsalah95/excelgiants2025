<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\VisionSection;
use App\Services\VisionSectionService;
use Illuminate\Http\Request;

class VisionSectionController extends Controller
{
    protected $service;

    public function __construct(VisionSectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $visionSections = $this->service->paginate();
        return view('dash.vision_sections.index', compact('visionSections'));
    }

    public function create()
    {
        return view('dash.vision_sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $this->service->create($request->all());

        return redirect()->route('vision-sections.index')->with('success', 'Vision section created successfully.');
    }

    public function edit(VisionSection $visionSection)
    {
        return view('dash.vision_sections.edit', compact('visionSection'));
    }

    public function update(Request $request, VisionSection $visionSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->service->update($visionSection, $request->all());

        return redirect()->route('vision-sections.index')->with('success', 'Vision section updated successfully.');
    }

    public function destroy(VisionSection $visionSection)
    {
        $this->service->delete($visionSection);
        return redirect()->route('vision-sections.index')->with('success', 'Vision section deleted successfully.');
    }
}
