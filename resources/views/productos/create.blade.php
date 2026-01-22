<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
</head>
<body>

<h1>Crear producto</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/productos" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Nombre</label><br>
        <input type="text" name="nombre" value="{{ old('nombre') }}" required>
    </div>

    <div>
        <label>Precio</label><br>
        <input type="number" name="precio" value="{{ old('precio') }}" required>
    </div>

    <div>
        <label>Stock</label><br>
        <input type="number" name="stock" value="{{ old('stock') }}" required>
    </div>

    <div>
        <label>Imagen</label><br>
        <input type="file" name="imagen" accept="image/*">
    </div>

    <br>
    <button type="submit">Guardar</button>

</form>

</body>
</html>
