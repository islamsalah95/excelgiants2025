<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\ServicesSection;
use App\Services\ServicesSectionService;
use Illuminate\Http\Request;

class ServicesSectionController extends Controller
{
    protected $service;

    public function __construct(ServicesSectionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $servicesSections = $this->service->paginate();
        return view('dash.services_sections.index', compact('servicesSections'));
    }

    public function create()
    {
        return view('dash.services_sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $this->service->create($request->all());

        return redirect()->route('services-sections.index')->with('success', 'Services section created successfully.');
    }

    public function edit(ServicesSection $servicesSection)
    {
        return view('dash.services_sections.edit', compact('servicesSection'));
    }

    public function update(Request $request, ServicesSection $servicesSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $this->service->update($servicesSection, $request->all());

        return redirect()->route('services-sections.index')->with('success', 'Services section updated successfully.');
    }

    public function destroy(ServicesSection $servicesSection)
    {
        $this->service->delete($servicesSection);
        return redirect()->route('services-sections.index')->with('success', 'Services section deleted successfully.');
    }
}
