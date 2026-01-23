<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Boleta de Venta - {{ $venta->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .container { width: 100%; max-width: 700px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px dashed #ccc; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; }

        .info-tabla { width: 100%; margin-bottom: 15px; }
        .info-tabla td { padding: 3px; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }

        .table-products { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table-products th { background-color: #f0f0f0; border-bottom: 1px solid #ddd; padding: 8px; text-align: left; }
        .table-products td { border-bottom: 1px solid #eee; padding: 8px; }

        .total-section { margin-top: 20px; text-align: right; border-top: 1px solid #333; padding-top: 10px; }
        .total-row { font-size: 16px; font-weight: bold; }

        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #777; border-top: 1px dashed #ccc; padding-top: 10px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>TECHStore</h1>
        <p>RUC: 20600000001</p>
        <p>Av. La Tecnología 123, Lima - Perú</p>
        <p>Tel: (01) 555-1234</p>
    </div>

    <table class="info-tabla">
        <tr>
            <td class="fw-bold">N° BOLETA:</td>
            <td>{{ $venta->id }}</td>
            <td class="fw-bold text-end">FECHA:</td>
            <td class="text-end">{{ $venta->created_at->format('d/m/Y H:i A') }}</td>
        </tr>
        <tr>
            <td class="fw-bold">CLIENTE:</td>
            <td>{{ $venta->cliente ?? 'Público General' }}</td>

            <td class="fw-bold text-end">CAJERO:</td>

            <td class="text-end">{{ auth()->user()->name ?? 'Cajero General' }}</td>
        </tr>
    </table>

    <table class="table-products">
        <thead>
        <tr>
            <th class="text-center" style="width: 50px;">Cant.</th>
            <th>Descripción</th>
            <th class="text-end" style="width: 100px;">P. Unit</th>
            <th class="text-end" style="width: 100px;">Importe</th>
        </tr>
        </thead>
        <tbody>
        @foreach($venta->detalles as $detalle)
            <tr>
                <td class="text-center">{{ $detalle->cantidad }}</td>
                <td>{{ $detalle->nombre_producto }}</td>
                <td class="text-end">S/ {{ number_format($detalle->precio_unitario, 2) }}</td>
                <td class="text-end">S/ {{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p class="total-row">TOTAL A PAGAR: S/ {{ number_format($venta->total, 2) }}</p>
    </div>

    <div class="footer">
        <p>Gracias por su preferencia</p>
        <p>Representación impresa de la Boleta de Venta Electrónica</p>
    </div>
</div>
</body>
</html>
