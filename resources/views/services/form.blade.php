@extends('layouts.app')
@section('title',($service->exists?'Editar':'Nuevo').' servicio | ServiceFlow')
@section('page-title',$service->exists?'Editar servicio':'Nuevo servicio')
@section('content')
<section class="panel form-panel"><form method="POST" action="{{ $service->exists ? route('services.update',$service) : route('services.store') }}" class="form-grid">@csrf @if($service->exists)@method('PUT')@endif
<label>Nombre<input name="name" value="{{ old('name',$service->name) }}" required></label>
<label>Precio base<input type="number" step="0.01" min="0" name="base_price" value="{{ old('base_price',$service->base_price) }}" required></label>
<label class="full">Descripción<textarea name="description" rows="5">{{ old('description',$service->description) }}</textarea></label>
<label class="checkbox full"><input type="checkbox" name="active" value="1" @checked(old('active',$service->exists ? $service->active : true))> Servicio activo</label>
<div class="full form-actions"><a class="button ghost" href="{{ route('services.index') }}">Cancelar</a><button class="button primary">Guardar servicio</button></div>
</form></section>
@endsection
