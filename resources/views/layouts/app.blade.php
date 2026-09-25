<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ServiceFlow')</title>
    <link rel="stylesheet" href="/css/app.css?v=1">
</head>
<body>
<div class="shell">
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}"><span>SF</span><strong>ServiceFlow</strong></a>
        <nav>
            <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Resumen</a>
            <a class="{{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">Clientes</a>
            <a class="{{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Órdenes</a>
            @if(auth()->user()->isAdmin())
                <a class="{{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Servicios</a>
            @endif
        </nav>
        <div class="sidebar-user">
            <small>{{ auth()->user()->isAdmin() ? 'Administrador' : 'Operador' }}</small>
            <strong>{{ auth()->user()->name }}</strong>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="link-button">Cerrar sesión</button></form>
        </div>
    </aside>
    <main class="main">
        <header class="topbar">
            <div><small>Panel de gestión</small><h1>@yield('page-title', 'ServiceFlow')</h1></div>
            <div class="top-actions">@yield('top-actions')</div>
        </header>
        @if(session('success'))<div class="alert success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert danger"><strong>Revisá los datos:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @yield('content')
    </main>
</div>
</body>
</html>
