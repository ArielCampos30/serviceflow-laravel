<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = WorkOrder::query()
            ->with(['client:id,name,company', 'service:id,name', 'assignee:id,name'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('priority'), fn ($query) => $query->where('priority', $request->string('priority')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return response()->json($orders);
    }

    public function show(WorkOrder $order): JsonResponse
    {
        return response()->json([
            'data' => $order->load(['client', 'service', 'assignee']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $order = WorkOrder::create($this->validated($request));

        return response()->json([
            'message' => 'Orden creada correctamente.',
            'data' => $order->load(['client', 'service', 'assignee']),
        ], 201);
    }

    public function update(Request $request, WorkOrder $order): JsonResponse
    {
        $order->update($this->validated($request));

        return response()->json([
            'message' => 'Orden actualizada correctamente.',
            'data' => $order->fresh()->load(['client', 'service', 'assignee']),
        ]);
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
