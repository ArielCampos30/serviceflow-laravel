@extends('layouts.app')
@section('title','Servicios | ServiceFlow')
@section('page-title','Servicios')
@section('top-actions')<a class="button primary" href="{{ route('services.create') }}">+ Nuevo servicio</a>@endsection
@section('content')
<div class="cards-grid">@foreach($services as $service)<article class="service-card"><div><span class="badge">{{ $service->active ? 'Activo' : 'Pausado' }}</span><h3>{{ $service->name }}</h3><p>{{ $service->description }}</p></div><div class="service-footer"><strong>${{ number_format((float)$service->base_price,0,',','.') }}</strong><a href="{{ route('services.edit',$service) }}">Editar</a></div></article>@endforeach</div>
@endsection
