@extends('layouts.guest')
@section('content')
<div class="login-card">
    <div class="login-brand"><span>SF</span><div><strong>ServiceFlow</strong><small>Gestión para empresas de servicios</small></div></div>
    <h1>Bienvenido</h1>
    <p>Ingresá al panel demostrativo para gestionar clientes y órdenes.</p>
    @if($errors->any())<div class="alert danger">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('login.store') }}" class="stack">@csrf
        <label>Email<input type="email" name="email" value="{{ old('email', 'admin@serviceflow.test') }}" required autofocus></label>
        <label>Contraseña<input type="password" name="password" required></label>
        <label class="checkbox"><input type="checkbox" name="remember"> Recordarme</label>
        <button class="button primary" type="submit">Ingresar</button>
    </form>
    <div class="demo-note"><strong>Demo pública</strong><span>admin@serviceflow.test · contraseña: ServiceFlowDemo!26</span></div>
</div>
@endsection
