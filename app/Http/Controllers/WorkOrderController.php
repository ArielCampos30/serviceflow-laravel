<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = WorkOrder::with(['client', 'service', 'assignee'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('priority'), fn ($q) => $q->where('priority', $request->string('priority')))
            ->when($request->filled('q'), fn ($q) => $q->where(function ($query) use ($request) {
                $term = '%'.$request->string('q')->trim().'%';
                $query->where('title', 'like', $term)->orWhereHas('client', fn ($client) => $client->where('name', 'like', $term));
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    public function create(): View
    {
        return view('orders.form', $this->formData(new WorkOrder));
    }

    public function store(Request $request): RedirectResponse
    {
        WorkOrder::create($this->validated($request));

        return redirect()->route('orders.index')->with('success', 'Orden creada correctamente.');
    }

    public function edit(WorkOrder $order): View
    {
        return view('orders.form', $this->formData($order));
    }

    public function update(Request $request, WorkOrder $order): RedirectResponse
    {
        $order->update($this->validated($request));

        return redirect()->route('orders.index')->with('success', 'Orden actualizada.');
    }

    public function destroy(WorkOrder $order): RedirectResponse
    {
        abort_unless(request()->user()?->isAdmin(), 403);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Orden eliminada.');
    }

    private function formData(WorkOrder $order): array
    {
        return [
            'order' => $order,
            'clients' => Client::where('status', '!=', 'inactive')->orderBy('name')->get(),
            'services' => Service::where('active', true)->orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'service_id' => ['required', 'exists:services,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:3000'],
            'status' => ['required', 'in:new,scheduled,in_progress,completed,cancelled'],
            'priority' => ['required', 'in:low,medium,high'],
            'scheduled_for' => ['nullable', 'date'],
            'total' => ['required', 'numeric', 'min:0'],
        ]);
    }
}
