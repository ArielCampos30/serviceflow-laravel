<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\WorkOrder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'clients' => Client::count(),
            'open_orders' => WorkOrder::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'urgent_orders' => WorkOrder::where('priority', 'high')->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completed_this_month' => WorkOrder::where('status', 'completed')->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count(),
        ];

        $recentOrders = WorkOrder::with(['client', 'service', 'assignee'])->latest()->limit(6)->get();

        return view('dashboard', compact('stats', 'recentOrders'));
    }
}
