<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;

class Ventas extends Component
{
    public $busqueda = '';
    public $carrito = [];
    public $total = 0;
    public $monto_recibido = 0;
    public $cliente = '';

    public function mount()
    {
        $this->carrito = [];
        $this->total = 0;
    }

    public function render()
    {
        $query = Producto::query();

        if (!empty($this->busqueda)) {
            $query->where(function($q) {
                $q->where('nombre', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('codigo_barras', 'like', '%' . $this->busqueda . '%');
            });
        }

        $productos = $query->latest()->take(50)->get();

        return view('livewire.ventas', [
            'productos' => $productos
        ]);
    }

    public function agregarProducto($id)
    {
        $producto = Producto::find($id);

        if (!$producto) return;

        if ($producto->stock <= 0) {
            session()->flash('error', 'Producto sin stock disponible');
            return;
        }

        if (isset($this->carrito[$id])) {
            if ($this->carrito[$id]['cantidad'] + 1 > $producto->stock) {
                session()->flash('error', 'No hay suficiente stock para agregar más');
                return;
            }
            $this->carrito[$id]['cantidad']++;
            $this->carrito[$id]['subtotal'] = $this->carrito[$id]['cantidad'] * $this->carrito[$id]['precio'];
        } else {
            $this->carrito[$id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'subtotal' => $producto->precio
            ];
        }

        $this->calcularTotal();
    }

    public function incrementar($id)
    {
        $producto = Producto::find($id);

        if (isset($this->carrito[$id])) {
            if ($this->carrito[$id]['cantidad'] + 1 > $producto->stock) {
                session()->flash('error', 'Stock insuficiente');
                return;
            }
            $this->carrito[$id]['cantidad']++;
            $this->carrito[$id]['subtotal'] = $this->carrito[$id]['cantidad'] * $this->carrito[$id]['precio'];
            $this->calcularTotal();
        }
    }

    public function decrementar($id)
    {
        if (isset($this->carrito[$id])) {
            if ($this->carrito[$id]['cantidad'] > 1) {
                $this->carrito[$id]['cantidad']--;
                $this->carrito[$id]['subtotal'] = $this->carrito[$id]['cantidad'] * $this->carrito[$id]['precio'];
            } else {
                unset($this->carrito[$id]);
            }
            $this->calcularTotal();
        }
    }

    public function eliminarProducto($id)
    {
        unset($this->carrito[$id]);
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->total = 0;
        foreach ($this->carrito as $item) {
            $this->total += $item['subtotal'];
        }
    }

    public function guardarVenta()
    {
        if (empty($this->carrito)) {
            return;
        }

        try {
            $clienteFinal = empty(trim($this->cliente)) ? 'Público General' : trim($this->cliente);

            $venta = Venta::create([
                'total' => $this->total,
                'cliente' => $clienteFinal
            ]);

            foreach ($this->carrito as $item) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['id'],
                    'nombre_producto' => $item['nombre'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['subtotal']
                ]);

                $producto = Producto::find($item['id']);
                if ($producto) {
                    $producto->stock = $producto->stock - $item['cantidad'];
                    $producto->save();
                }
            }

            $ventaId = $venta->id;

            $this->carrito = [];
            $this->total = 0;
            $this->monto_recibido = 0;
            $this->busqueda = '';
            $this->cliente = '';

            session()->flash('message', '¡Venta registrada correctamente! (ID: ' . $ventaId . ')');
            session()->flash('venta_id', $ventaId);

        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar la venta: ' . $e->getMessage());
        }
    }
}
