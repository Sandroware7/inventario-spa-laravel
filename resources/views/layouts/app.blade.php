<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistema de Inventario' }} - TECHStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

@auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/ventas" wire:navigate>
                <i class="bi bi-box-seam me-2"></i>TECHStore
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('inventario') ? 'active text-warning' : '' }}" href="{{ route('inventario') }}" wire:navigate>
                            <i class="bi bi-list-ul me-1"></i> Inventario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ventas') ? 'active text-warning' : '' }}" href="{{ route('ventas') }}" wire:navigate>
                            <i class="bi bi-cart4 me-1"></i> Vender
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('historial') ? 'active text-warning' : '' }}" href="{{ route('historial') }}" wire:navigate>
                            <i class="bi bi-clock-history me-1"></i> Historial
                        </a>
                    </li>
                    <li class="nav-item mx-2 text-white opacity-25">|</li>
                    <li class="nav-item dropdown" x-data="{ open: false }">
                        <a class="nav-link dropdown-toggle text-white fw-bold"
                           href="#"
                           role="button"
                           @click="open = !open"
                           @click.outside="open = false"
                           :class="{ 'show': open }">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" :class="{ 'show': open }">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endauth

<div class="container">
    {{ $slot }}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
