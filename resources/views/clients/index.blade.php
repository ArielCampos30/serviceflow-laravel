@extends('layouts.app')
@section('title','Clientes | ServiceFlow')
@section('page-title','Clientes')
@section('top-actions')
@if(auth()->user()->isAdmin())
<a class="button primary" href="{{ route('clients.create') }}">+ Nuevo cliente</a>
@endif
@endsection
@section('content')
<section class="panel">
<form class="filters" method="GET"><input name="q" value="{{ request('q') }}" placeholder="Buscar por nombre, empresa o email"><button class="button" type="submit">Buscar</button><a class="button ghost" href="{{ route('clients.index') }}">Limpiar</a></form>
<div class="table-wrap"><table><thead><tr><th>Cliente</th><th>Empresa</th><th>Contacto</th><th>Estado</th><th>Órdenes</th><th></th></tr></thead><tbody>
@forelse($clients as $client)<tr><td><strong>{{ $client->name }}</strong></td><td>{{ $client->company ?: '—' }}</td><td>{{ $client->email ?: '—' }}<br><small>{{ $client->phone }}</small></td><td><span class="badge">{{ $client->status }}</span></td><td>{{ $client->workOrders()->count() }}</td><td>@if(auth()->user()->isAdmin())<a href="{{ route('clients.edit',$client) }}">Editar</a>@endif</td></tr>@empty<tr><td colspan="6">No hay clientes para mostrar.</td></tr>@endforelse
</tbody></table></div>
<div class="pagination">{{ $clients->links() }}</div>
</section>
@endsection
