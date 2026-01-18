<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\WorksSection;
use App\Services\WorksSectionService;
use Illuminate\Http\Request;

class WorksSectionController extends Controller
{
    protected $service;

    public function __construct(WorksSectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $worksSections = $this->service->paginate();
        return view('dash.works_sections.index', compact('worksSections'));
    }

    public function create()
    {
        return view('dash.works_sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'step_number' => 'nullable|string|max:10',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $this->service->create($request->all());

        return redirect()->route('works-sections.index')->with('success', 'Works section created successfully.');
    }

    public function edit(WorksSection $worksSection)
    {
        return view('dash.works_sections.edit', compact('worksSection'));
    }

    public function update(Request $request, WorksSection $worksSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'step_number' => 'nullable|string|max:10',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->service->update($worksSection, $request->all());

        return redirect()->route('works-sections.index')->with('success', 'Works section updated successfully.');
    }

    public function destroy(WorksSection $worksSection)
    {
        $this->service->delete($worksSection);
        return redirect()->route('works-sections.index')->with('success', 'Works section deleted successfully.');
    }
}
