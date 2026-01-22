<div>
    <h1>Gestión de Inventario</h1>

    {{-- Mensajes de éxito --}}
    @if (session()->has('success'))
        <div style="color: green; margin-bottom: 10px; border: 1px solid green; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Mensajes de error general (opcional) --}}
    @if (session()->has('error'))
        <div style="color: red; margin-bottom: 10px; border: 1px solid red; padding: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <hr>

    <h3>{{ $modoEdicion ? 'Editar Producto' : 'Crear Producto' }}</h3>

    <form wire:submit.prevent="{{ $modoEdicion ? 'actualizar' : 'guardar' }}">

        {{-- Nombre --}}
        <div>
            <label>Nombre:</label><br>
            <input type="text" wire:model="nombre" placeholder="Nombre del repuesto">
            @error('nombre') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <br>

        {{-- Precio --}}
        <div>
            <label>Precio:</label><br>
            <input type="number" wire:model="precio" step="0.01" placeholder="Precio">
            @error('precio') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <br>

        {{-- Stock --}}
        <div>
            <label>Stock:</label><br>
            <input type="number" wire:model="stock" placeholder="Cantidad">
            @error('stock') <div style="color:red">{{ $message }}</div> @enderror
        </div>
        <br>

        {{-- Imagen (Sección Crítica) --}}
        <div style="border: 1px dashed #ccc; padding: 10px; margin-bottom: 10px;">
            <label>Imagen del Repuesto:</label><br>

            {{-- Input de archivo --}}
            {{-- Usamos wire:model.live (o simplemente wire:model) para ver la preview al instante --}}
            {{-- Agregamos un ID rand para forzar el reseteo del input si es necesario --}}
            <input type="file" wire:model="imagen" id="upload-{{ $iteration ?? 0 }}">

            @error('imagen') <div style="color:red">{{ $message }}</div> @enderror

            {{-- Indicador de carga: Solo se ve mientras la imagen sube --}}
            <div wire:loading wire:target="imagen" style="color: blue;">
                <strong>Subiendo imagen, espera por favor...</strong>
            </div>

            {{-- PREVISUALIZACIÓN --}}
            <div style="margin-top: 10px;">
                @if ($imagen)
                    {{-- Caso 1: El usuario acaba de seleccionar una imagen nueva --}}
                    <p>Previsualización nueva:</p>
                    <img src="{{ $imagen->temporaryUrl() }}" width="100" style="border: 2px solid blue;">

                @elseif ($modoEdicion && $imagen_actual)
                    {{-- Caso 2: Estamos editando y hay una imagen guardada previamente --}}
                    <p>Imagen Actual:</p>
                    <img src="{{ asset('storage/' . $imagen_actual) }}" width="100" style="border: 2px solid gray;">
                @endif
            </div>
        </div>

        {{-- Botones de Acción --}}
        {{-- wire:loading.attr="disabled" deshabilita el botón mientras se sube la imagen o se procesa --}}
        @if ($modoEdicion)
            <button type="submit" wire:loading.attr="disabled">Actualizar</button>
            <button type="button" wire:click="resetFormulario" wire:loading.attr="disabled">Cancelar</button>
        @else
            <button type="submit" wire:loading.attr="disabled">Guardar</button>
        @endif

        {{-- Mensaje de "Procesando" al guardar --}}
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
                        {{-- asset() apunta a public/storage/... que es el symlink --}}
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
