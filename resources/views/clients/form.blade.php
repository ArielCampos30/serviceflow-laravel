@extends('layouts.app')
@section('title',($client->exists?'Editar':'Nuevo').' cliente | ServiceFlow')
@section('page-title',$client->exists?'Editar cliente':'Nuevo cliente')
@section('content')
<section class="panel form-panel"><form method="POST" action="{{ $client->exists ? route('clients.update',$client) : route('clients.store') }}" class="form-grid">@csrf @if($client->exists)@method('PUT')@endif
<label>Nombre<input name="name" value="{{ old('name',$client->name) }}" required></label>
<label>Empresa<input name="company" value="{{ old('company',$client->company) }}"></label>
<label>Email<input type="email" name="email" value="{{ old('email',$client->email) }}"></label>
<label>Teléfono<input name="phone" value="{{ old('phone',$client->phone) }}"></label>
<label>Estado<select name="status">@foreach(['lead'=>'Lead','active'=>'Activo','inactive'=>'Inactivo'] as $value=>$label)<option value="{{ $value }}" @selected(old('status',$client->status ?: 'lead')===$value)>{{ $label }}</option>@endforeach</select></label>
<label class="full">Notas<textarea name="notes" rows="5">{{ old('notes',$client->notes) }}</textarea></label>
<div class="full form-actions"><a class="button ghost" href="{{ route('clients.index') }}">Cancelar</a><button class="button primary">Guardar cliente</button></div>
</form></section>
@endsection
