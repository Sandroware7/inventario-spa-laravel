<div class="container mt-4">
    <h1 class="mb-4 text-center">Gestión de Inventario</h1>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm" style="background-color: #015e83; color: white;">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Productos</h5>
                    <p class="display-6 fw-bold mb-0">{{ $totalProductos }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm" style="background-color: #336816; color: white;">
                <div class="card-body text-center">
                    <h5 class="card-title">Valor Inventario</h5>
                    <p class="display-6 fw-bold mb-0">S/ {{ number_format($valorInventario, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div
                wire:click="toggleFiltroBajoStock"
                class="card h-100 shadow-sm {{ $filtroBajoStock ? 'border-warning border-3 bg-warning-subtle' : 'bg-warning-subtle' }}"
                style="cursor: pointer;"
            >
                <div class="card-body text-center text-warning-emphasis">
                    <h6 class="card-title">Bajo Stock</h6>
                    <p class="h2 fw-bold mb-0">{{ $productosBajoStock }}</p>
                    @if($productosBajoStock > 0 && !$filtroBajoStock)
                        <small class="text-decoration-underline">Ver lista</small>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div
                wire:click="toggleFiltroSinStock"
                class="card h-100 shadow-sm {{ $filtroSinStock ? 'border-danger border-3 bg-danger-subtle' : 'bg-danger-subtle' }}"
                style="cursor: pointer;"
            >
                <div class="card-body text-center text-danger-emphasis">
                    <h6 class="card-title">Agotados</h6>
                    <p class="h2 fw-bold mb-0">{{ $productosSinStock }}</p>
                    @if($productosSinStock > 0 && !$filtroSinStock)
                        <small class="text-decoration-underline">Ver lista</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(auth()->user()->role === 'admin')
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">{{ $producto_id ? 'Editar Producto' : 'Nuevo Producto' }}</h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="{{ $producto_id ? 'update' : 'store' }}" class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" wire:model="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Ej: Teclado Razer">
                        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text">S/</span>
                            <input type="number" step="0.01" wire:model="precio" class="form-control @error('precio') is-invalid @enderror" placeholder="0.00">
                            @error('precio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Stock</label>
                        <input type="number" wire:model="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="0">
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Categoría</label>
                        <select wire:model="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror">
                            <option value="">Seleccione...</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                        @error('categoria_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Imagen</label>
                        <input type="file" wire:model="{{ $producto_id ? 'imagen_nueva' : 'imagen' }}" id="upload-{{ $iteration ?? 0 }}" class="form-control">

                        <div wire:loading wire:target="imagen, imagen_nueva" class="text-primary mt-2">
                            <small>Cargando imagen...</small>
                        </div>

                        @if ($imagen_nueva)
                            <div class="mt-2">
                                <img src="{{ $imagen_nueva->temporaryUrl() }}" class="img-thumbnail" style="height: 80px;">
                            </div>
                        @elseif ($imagen && !$producto_id)
                            <div class="mt-2">
                                <img src="{{ $imagen->temporaryUrl() }}" class="img-thumbnail" style="height: 80px;">
                            </div>
                        @elseif ($producto_id && $imagen)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $imagen) }}" class="img-thumbnail" style="height: 80px;">
                            </div>
                        @endif

                        @error('imagen') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        @error('imagen_nueva') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 text-end">
                        @if ($producto_id)
                            <button type="button" wire:click="resetInputFields" class="btn btn-secondary me-2">Cancelar</button>
                            <button type="submit" class="btn text-white" style="background-color: #c68800; border-color: #bd7903;">Actualizar Producto</button>
                        @else
                            <button type="submit" class="btn btn-primary">Guardar Producto</button>
                        @endif

                        <span wire:loading wire:target="store, update" class="ms-2 text-muted">
                        Procesando...
                    </span>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($filtroSinStock)
        <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
            <div><strong>Filtro Activo:</strong> Mostrando productos AGOTADOS</div>
            <button wire:click="toggleFiltroSinStock" class="btn btn-sm btn-outline-danger">Quitar Filtro</button>
        </div>
    @elseif($filtroBajoStock)
        <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
            <div><strong>Filtro Activo:</strong> Mostrando productos con BAJO STOCK</div>
            <button wire:click="toggleFiltroBajoStock" class="btn btn-sm btn-outline-warning">Quitar Filtro</button>
        </div>
    @endif

    <div class="row mb-3 g-2">
        <div class="col-md-3">
            <select wire:model.live="filtroCategoria" class="form-select form-select-lg">
                <option value="">Todas las Categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-9">
            <input wire:model.live="busqueda" type="text" class="form-control form-control-lg" placeholder="🔍 Buscar por nombre o cantidad...">
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-3">Imagen</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Categoría</th>
                        <th scope="col" class="text-end pe-3">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($productos as $producto)
                        <tr class="{{ $producto->stock == 0 ? 'table-danger' : ($producto->stock < 5 ? 'table-warning' : '') }}">
                            <td class="ps-3">
                                @if ($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="rounded" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <span class="text-muted small">Sin img</span>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $producto->nombre }}</td>
                            <td>S/ {{ number_format($producto->precio, 2) }}</td>
                            <td>
                                <span class="badge {{ $producto->stock == 0 ? 'text-bg-danger' : ($producto->stock < 5 ? 'text-bg-warning' : 'text-bg-secondary') }}">
                                    {{ $producto->stock }}
                                </span>
                                @if($producto->stock == 0)
                                    <div class="small text-danger fw-bold">¡AGOTADO!</div>
                                @elseif($producto->stock < 5)
                                    <div class="small text-warning-emphasis fw-bold">¡BAJO!</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $producto->categoria?->nombre ?? 'General' }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                @if(auth()->user()->role === 'admin')
                                    <button wire:click="edit('{{ $producto->id }}')"
                                            class="btn btn-sm text-white me-1"
                                            style="background-color: #4279c1; border-color: #0e3965;">
                                        Editar
                                    </button>

                                    <button
                                        wire:click="delete('{{ $producto->id }}')"
                                        onclick="confirm('¿Seguro que deseas eliminar este producto?') || event.stopImmediatePropagation()"
                                        class="btn btn-sm text-white"
                                        style="background-color: #c32828; border-color: #7c0000;">
                                        Eliminar
                                    </button>
                                @else
                                    <span class="badge bg-secondary">Solo Lectura</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No se encontraron productos.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $productos->links('pagination::bootstrap-5') }}
    </div>
</div>
