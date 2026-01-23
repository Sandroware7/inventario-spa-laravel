<div>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input
                            wire:model.live.debounce.300ms="busqueda"
                            type="text"
                            class="form-control bg-light border-start-0"
                            placeholder="Buscar producto (escribir)..."
                            autofocus
                        >
                    </div>
                </div>

                <div class="card-body bg-light overflow-auto" style="height: 650px;">
                    <div class="row g-2">
                        @forelse($productos as $producto)
                            <div class="col-md-4 col-sm-6" wire:key="{{ $producto->id }}">
                                <div class="card h-100 shadow-sm border-0 product-card">
                                    <div class="position-relative" style="height: 140px; overflow: hidden; background: #f8f9fa;">
                                        @if($producto->imagen)
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="w-100 h-100" style="object-fit: contain; padding: 10px;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                                <i class="bi bi-camera-fill fs-1 opacity-25"></i>
                                            </div>
                                        @endif

                                        <span class="position-absolute top-0 end-0 badge {{ $producto->stock < 5 ? 'bg-danger' : 'bg-success' }} m-2">
                                            Stock: {{ $producto->stock }}
                                        </span>
                                    </div>

                                    <div class="card-body p-3 d-flex flex-column">
                                        <h6 class="card-title text-truncate fw-bold mb-1" title="{{ $producto->nombre }}">
                                            {{ $producto->nombre }}
                                        </h6>
                                        <p class="text-primary fs-5 fw-bold mb-3">
                                            S/ {{ number_format($producto->precio, 2) }}
                                        </p>

                                        <button
                                            wire:click.prevent="agregarProducto('{{ $producto->id }}')"
                                            wire:loading.attr="disabled"
                                            class="btn btn-primary w-100 mt-auto d-flex align-items-center justify-content-center gap-2">
                                            <span wire:loading.remove wire:target="agregarProducto('{{ $producto->id }}')">
                                                <i class="bi bi-plus-lg"></i> Agregar
                                            </span>
                                            <span wire:loading wire:target="agregarProducto('{{ $producto->id }}')">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center mt-5 text-muted">
                                <div class="mb-3">
                                    <i class="bi bi-search display-1 opacity-25"></i>
                                </div>
                                <h5>No se encontraron productos</h5>
                                <p class="small">
                                    Asegúrate de que el producto tenga <strong>Stock > 0</strong> <br>
                                    o intenta con otro nombre.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg h-100 border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-cart3 me-2"></i>Carrito de Compras</h5>
                </div>

                <div class="card-body p-0 d-flex flex-column" style="height: 650px;">
                    <div class="flex-grow-1 overflow-auto p-0 bg-white">
                        @if(count($carrito) > 0)
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light sticky-top small text-muted">
                                <tr>
                                    <th class="ps-3">Producto</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($carrito as $id => $item)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold text-dark small">{{ $item['nombre'] }}</div>
                                            <div class="text-muted" style="font-size: 0.8rem;">
                                                S/ {{ number_format($item['precio'], 2) }} unit.
                                            </div>
                                            <a href="#" wire:click.prevent="eliminarProducto('{{ $id }}')" class="text-danger text-decoration-none" style="font-size: 0.75rem;">
                                                <i class="bi bi-trash"></i> Quitar
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <button wire:click="decrementar('{{ $id }}')" class="btn btn-sm btn-outline-secondary px-2 py-0 fw-bold">-</button>
                                                <span class="fw-bold mx-1" style="width: 20px;">{{ $item['cantidad'] }}</span>
                                                <button wire:click="incrementar('{{ $id }}')" class="btn btn-sm btn-outline-primary px-2 py-0 fw-bold">+</button>
                                            </div>
                                        </td>
                                        <td class="text-end pe-3 fw-bold text-dark">
                                            S/ {{ number_format($item['subtotal'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                                <div class="bg-light rounded-circle p-4 mb-3">
                                    <i class="bi bi-basket3 display-4 text-secondary opacity-50"></i>
                                </div>
                                <p class="mb-0 fw-medium">El carrito está vacío</p>
                                <small>Selecciona productos de la izquierda</small>
                            </div>
                        @endif
                    </div>

                    <div class="p-4 bg-light border-top">
                        @if(session('error'))
                            <div class="alert alert-danger py-2 small d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if(session('message'))
                            <div class="alert alert-success py-3 text-center shadow-sm">
                                <div class="fw-bold mb-2">
                                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('message') }}
                                </div>

                                @if(session('venta_id'))
                                    <a href="{{ route('venta.pdf', session('venta_id')) }}"
                                       target="_blank"
                                       class="btn btn-dark btn-sm fw-bold">
                                        <i class="bi bi-printer-fill me-2"></i> IMPRIMIR BOLETA
                                    </a>
                                @endif
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label small text-muted">Nombre del Cliente / Razón Social</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                <input
                                    type="text"
                                    wire:model="cliente"
                                    class="form-control"
                                    placeholder="John Doe"
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-end mb-3">
                            <span class="text-muted">Total a Pagar</span>
                            <span class="display-6 fw-bold text-primary">S/ {{ number_format($total, 2) }}</span>
                        </div>

                        <button
                            wire:click="guardarVenta"
                            class="btn btn-success w-100 py-3 fw-bold shadow-sm"
                            {{ count($carrito) == 0 ? 'disabled' : '' }}
                            onclick="confirm('¿Confirmar y procesar venta?') || event.stopImmediatePropagation()"
                        >
                            <i class="bi bi-cash-coin me-2"></i> COBRAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
