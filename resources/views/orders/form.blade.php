@extends('layouts.app')
@section('title',($order->exists?'Gestionar':'Nueva').' orden | ServiceFlow')
@section('page-title',$order->exists?'Gestionar orden':'Nueva orden')
@section('content')
<section class="panel form-panel"><form method="POST" action="{{ $order->exists ? route('orders.update',$order) : route('orders.store') }}" class="form-grid">@csrf @if($order->exists)@method('PUT')@endif
<label>Cliente<select name="client_id" required><option value="">Seleccionar</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id',$order->client_id)==$client->id)>{{ $client->name }}{{ $client->company ? ' · '.$client->company : '' }}</option>@endforeach</select></label>
<label>Servicio<select name="service_id" required><option value="">Seleccionar</option>@foreach($services as $service)<option value="{{ $service->id }}" @selected(old('service_id',$order->service_id)==$service->id)>{{ $service->name }}</option>@endforeach</select></label>
<label class="full">Título<input name="title" value="{{ old('title',$order->title) }}" required></label>
<label>Estado<select name="status">@foreach(['new'=>'Nueva','scheduled'=>'Programada','in_progress'=>'En curso','completed'=>'Completada','cancelled'=>'Cancelada'] as $v=>$l)<option value="{{ $v }}" @selected(old('status',$order->status ?: 'new')===$v)>{{ $l }}</option>@endforeach</select></label>
<label>Prioridad<select name="priority">@foreach(['low'=>'Baja','medium'=>'Media','high'=>'Alta'] as $v=>$l)<option value="{{ $v }}" @selected(old('priority',$order->priority ?: 'medium')===$v)>{{ $l }}</option>@endforeach</select></label>
<label>Responsable<select name="assigned_to"><option value="">Sin asignar</option>@foreach($users as $user)<option value="{{ $user->id }}" @selected(old('assigned_to',$order->assigned_to)==$user->id)>{{ $user->name }}</option>@endforeach</select></label>
<label>Fecha programada<input type="datetime-local" name="scheduled_for" value="{{ old('scheduled_for',$order->scheduled_for?->format('Y-m-d\\TH:i')) }}"></label>
<label>Total<input type="number" min="0" step="0.01" name="total" value="{{ old('total',$order->total ?: 0) }}" required></label>
<label class="full">Descripción<textarea name="description" rows="6">{{ old('description',$order->description) }}</textarea></label>
<div class="full form-actions"><a class="button ghost" href="{{ route('orders.index') }}">Cancelar</a><button class="button primary">Guardar orden</button></div>
</form></section>
@endsection
