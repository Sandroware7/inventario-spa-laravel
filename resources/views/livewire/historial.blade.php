<div class="container mt-4">
    <h2 class="mb-4">Historial de Ventas</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="ps-4">ID / Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th class="text-end pe-4">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-primary small">{{ $venta->id }}</div>
                            <div class="text-muted small">{{ $venta->created_at->format('d/m/Y h:i A') }}</div>
                        </td>
                        <td>{{ $venta->cliente ?? 'Público General' }}</td>
                        <td class="fw-bold">S/ {{ number_format($venta->total, 2) }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('venta.pdf', $venta->id) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $ventas->links() }}
    </div>
</div>
