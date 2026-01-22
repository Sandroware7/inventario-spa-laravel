<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
</head>
<body>

@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif


<h1>Listado de Productos</h1>

<a href="/productos/crear">Crear producto</a>

<hr>

@foreach ($productos as $producto)
    <div style="margin-bottom: 15px;">

        @if ($producto->imagen)
            <img src="{{ asset('storage/' . $producto->imagen) }}" width="120">
        @endif

        <strong>{{ $producto->nombre }}</strong><br>
        Precio: {{ $producto->precio }} <br>
        Stock: {{ $producto->stock }} <br>

        <a href="/productos/{{ $producto->id }}/editar">Editar</a>

        <form action="/productos/{{ $producto->id }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                🗑️ Eliminar
            </button>
        </form>
    </div>
@endforeach


</body>
</html>
