@extends('layouts.app')
@section('title','Órdenes | ServiceFlow')
@section('page-title','Órdenes de trabajo')
@section('top-actions')<a class="button primary" href="{{ route('orders.create') }}">+ Nueva orden</a>@endsection
@section('content')
<section class="panel">
<form class="filters" method="GET"><input name="q" value="{{ request('q') }}" placeholder="Buscar orden o cliente"><select name="status"><option value="">Todos los estados</option>@foreach(['new'=>'Nueva','scheduled'=>'Programada','in_progress'=>'En curso','completed'=>'Completada','cancelled'=>'Cancelada'] as $v=>$l)<option value="{{ $v }}" @selected(request('status')===$v)>{{ $l }}</option>@endforeach</select><select name="priority"><option value="">Todas las prioridades</option>@foreach(['low'=>'Baja','medium'=>'Media','high'=>'Alta'] as $v=>$l)<option value="{{ $v }}" @selected(request('priority')===$v)>{{ $l }}</option>@endforeach</select><button class="button">Filtrar</button></form>
<div class="table-wrap"><table><thead><tr><th>Orden</th><th>Cliente</th><th>Servicio</th><th>Programada</th><th>Estado</th><th>Total</th><th></th></tr></thead><tbody>
@forelse($orders as $order)<tr><td><strong>#{{ str_pad($order->id,4,'0',STR_PAD_LEFT) }}</strong><br><small>{{ $order->title }}</small></td><td>{{ $order->client->name }}</td><td>{{ $order->service->name }}</td><td>{{ $order->scheduled_for?->format('d/m/Y H:i') ?? 'Sin fecha' }}</td><td><span class="badge status-{{ $order->status }}">{{ str_replace('_',' ',$order->status) }}</span></td><td>${{ number_format((float)$order->total,0,',','.') }}</td><td><a href="{{ route('orders.edit',$order) }}">Gestionar</a></td></tr>@empty<tr><td colspan="7">No hay órdenes para mostrar.</td></tr>@endforelse
</tbody></table></div><div class="pagination">{{ $orders->links() }}</div>
</section>
@endsection
