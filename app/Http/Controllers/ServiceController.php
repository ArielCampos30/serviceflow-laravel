<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('services.index', ['services' => Service::orderBy('name')->get()]);
    }

    public function create(): View
    {
        return view('services.form', ['service' => new Service]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['active'] = $request->boolean('active');
        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Service $service): View
    {
        return view('services.form', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validated($request);
        $data['active'] = $request->boolean('active');
        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        abort_if($service->workOrders()->exists(), 422, 'No se puede eliminar un servicio con órdenes asociadas.');
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Servicio eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:1000'],
            'base_price' => ['required', 'numeric', 'min:0'],
        ]);
    }
}
