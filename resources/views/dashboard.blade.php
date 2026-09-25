@extends('layouts.app')
@section('title','Resumen | ServiceFlow')
@section('page-title','Resumen')
@section('top-actions')<a class="button primary" href="{{ route('orders.create') }}">+ Nueva orden</a>@endsection
@section('content')
<div class="stats-grid">
    <article class="stat-card"><span>Clientes</span><strong>{{ $stats['clients'] }}</strong><small>registrados</small></article>
    <article class="stat-card"><span>Órdenes abiertas</span><strong>{{ $stats['open_orders'] }}</strong><small>pendientes de cierre</small></article>
    <article class="stat-card"><span>Prioridad alta</span><strong>{{ $stats['urgent_orders'] }}</strong><small>requieren atención</small></article>
    <article class="stat-card"><span>Completadas</span><strong>{{ $stats['completed_this_month'] }}</strong><small>este mes</small></article>
</div>
<section class="panel">
    <div class="panel-head"><div><small>Actividad reciente</small><h2>Últimas órdenes</h2></div><a href="{{ route('orders.index') }}">Ver todas</a></div>
    <div class="table-wrap"><table><thead><tr><th>Orden</th><th>Cliente</th><th>Servicio</th><th>Estado</th><th>Prioridad</th><th>Responsable</th></tr></thead><tbody>
    @forelse($recentOrders as $order)<tr><td><a href="{{ route('orders.edit',$order) }}">#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }} · {{ $order->title }}</a></td><td>{{ $order->client->name }}</td><td>{{ $order->service->name }}</td><td><span class="badge status-{{ $order->status }}">{{ str_replace('_',' ',$order->status) }}</span></td><td><span class="badge priority-{{ $order->priority }}">{{ $order->priority }}</span></td><td>{{ $order->assignee?->name ?? 'Sin asignar' }}</td></tr>@empty<tr><td colspan="6">Todavía no hay órdenes.</td></tr>@endforelse
    </tbody></table></div>
</section>
@endsection
