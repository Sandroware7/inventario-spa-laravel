<div>
    <h1>Gestión de Inventario</h1>

    @if (session()->has('success'))
        <div style="color: green; margin-bottom: 10px; border: 1px solid green; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div style="color: red; margin-bottom: 10px; border: 1px solid red; padding: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <hr>

    <h3>{{ $modoEdicion ? 'Editar Producto' : 'Crear Producto' }}</h3>

    <form wire:submit.prevent="{{ $modoEdicion ? 'actualizar' : 'guardar' }}">

        <div>
            <label>Nombre:</label><br>
            <input type="text" wire:model="nombre" placeholder="Nombre del repuesto">
            @error('nombre') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <br>

        <div>
            <label>Precio:</label><br>
            <input type="number" wire:model="precio" step="0.01" placeholder="Precio">
            @error('precio') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <br>

        <div>
            <label>Stock:</label><br>
            <input type="number" wire:model="stock" placeholder="Cantidad">
            @error('stock') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <br>

        <div style="border: 1px dashed #ccc; padding: 10px; margin-bottom: 10px;">
            <label>Imagen del Repuesto:</label><br>

            <input type="file" wire:model="imagen" id="upload-{{ $iteration ?? 0 }}">

            @error('imagen') <div style="color:red">{{ $message }}</div> @enderror

            <div wire:loading wire:target="imagen" style="color: blue;">
                <strong>Subiendo imagen, espera por favor...</strong>
            </div>

            <div style="margin-top: 10px;">
                @if ($imagen)
                    <p>Previsualización nueva:</p>
                    <img src="{{ $imagen->temporaryUrl() }}" width="100" style="border: 2px solid blue;">

                @elseif ($modoEdicion && $imagen_actual)
                    <p>Imagen Actual:</p>
                    <img src="{{ asset('storage/' . $imagen_actual) }}" width="100" style="border: 2px solid gray;">
                @endif
            </div>
        </div>

        @if ($modoEdicion)
            <button type="submit" wire:loading.attr="disabled">Actualizar</button>
            <button type="button" wire:click="resetFormulario" wire:loading.attr="disabled">Cancelar</button>
        @else
            <button type="submit" wire:loading.attr="disabled">Guardar</button>
        @endif

        <span wire:loading wire:target="guardar, actualizar" style="margin-left: 10px; color: gray;">
            Procesando...
        </span>

    </form>

    <hr>

    <h3>Listado de Productos</h3>

    <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
        <thead>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($productos as $producto)
            <tr>
                <td>
                    @if ($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" width="60" height="60" style="object-fit: cover;">
                    @else
                        <span>Sin imagen</span>
                    @endif
                </td>
                <td>{{ $producto->nombre }}</td>
                <td>${{ number_format($producto->precio, 2) }}</td>
                <td>{{ $producto->stock }}</td>
                <td>
                    <button wire:click="editar('{{ $producto->id }}')">Editar</button>

                    <button
                        wire:click="eliminar('{{ $producto->id }}')"
                        onclick="confirm('¿Seguro que deseas eliminar este producto?') || event.stopImmediatePropagation()"
                        style="background-color: #ffcccc;">
                        Eliminar
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
