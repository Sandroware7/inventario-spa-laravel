<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
</head>
<body>

<h1>Editar producto</h1>

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/productos/{{ $producto->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}">
    </div>

    <div>
        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" min="1" value="{{ old('precio', $producto->precio) }}">
    </div>

    <div>
        <label>Stock:</label>
        <input type="number" name="stock" min="1" value="{{ old('stock', $producto->stock) }}">
    </div>

    <div>
        <label>Imagen:</label>
        <input type="file" name="imagen">
    </div>

    <button type="submit">Actualizar</button>

</form>

<a href="/">Volver</a>

</body>
</html>
